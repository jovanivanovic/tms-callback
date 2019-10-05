<template>
    <b-card no-body header="Administration" style="width: 800px;">
        <vuetable ref="vuetable"
                  :css="css.table"
                  :api-mode="false"
                  :fields="fields"
                  :per-page="perPage"
                  :data-manager="dataManager"
                  pagination-path="pagination"
                  @vuetable:pagination-data="onPaginationData"
        >
            <div slot="actions" slot-scope="props">
                <b-button-group>
                    <b-button size="sm" variant="primary" @click="onActionClicked('view-item', props.rowData)">
                        <i class="fa fa-eye"></i>
                    </b-button>
                    <b-button size="sm" variant="danger" @click="onActionClicked('archive-item', props.rowData)">
                        <i class="fa fa-archive"></i>
                    </b-button>
                </b-button-group>
            </div>
        </vuetable>
        <div style="padding-top:10px">
            <vuetable-pagination ref="pagination"
                                 :css="css.pagination"
                                 class="pull-right"
                                 @vuetable-pagination:change-page="onChangePage"
            ></vuetable-pagination>
        </div>
    </b-card>
</template>

<script>
    import { getAllCallbacks, archiveCallback } from "../../services/api/admin";
    import Vuetable from 'vuetable-2';
    import VuetablePagination from "./VuetablePagination";
    import FieldsDef from "./utility/FieldsDef";
    import CssConfig from "./utility/CssConfig";
    import _ from 'lodash';

    export default {
        name: 'AdminListPage',
        data() {
            return {
                css: CssConfig,
                fields: FieldsDef,
                perPage: 10,
                data: []
            }
        },
        components: {
            Vuetable,
            VuetablePagination
        },
        mounted() {
            this.getData();
        },
        watch: {
            data(newVal, oldVal) {
                this.$refs.vuetable.refresh();
            }
        },
        methods: {
            getData() {
                getAllCallbacks()
                    .then(res => {
                        this.data = res;
                    })
                    .catch(error => {
                        this.$bvToast.toast(err, {
                            title: 'Error',
                            autoHideDelay: 2500,
                            variant: 'danger',
                            solid: true,
                            toaster: 'b-toaster-bottom-right'
                        });

                        console.log(err);
                    });
            },
            onPaginationData(paginationData) {
                this.$refs.pagination.setPaginationData(paginationData);
            },
            onChangePage(page) {
                this.$refs.vuetable.changePage(page);
            },
            dataManager(sortOrder, pagination) {
                if (this.data.length < 1) return;

                let local = this.data;

                if (sortOrder.length > 0) {
                    local = _.orderBy(
                        local,
                        sortOrder[0].sortField,
                        sortOrder[0].direction
                    );
                }

                pagination = this.$refs.vuetable.makePagination(
                    local.length,
                    this.perPage
                );

                let from = pagination.from - 1;
                let to = from + this.perPage;

                return {
                    pagination: pagination,
                    data: _.slice(local, from, to)
                };
            },
            onActionClicked(action, data) {
                switch (action) {
                    case 'view-item':
                        this.viewCallback(data);
                        break;

                    case 'archive-item':
                        this.archiveCallback(data);
                        break;
                }
            },
            viewCallback(data) {
                this.$router.push({ path: `/admin/${data.id}` });
            },
            archiveCallback(data) {
                archiveCallback(data.id)
                    .then(res => {
                        this.$bvToast.toast(res.message, {
                            title: 'Archived',
                            autoHideDelay: 2500,
                            variant: 'success',
                            solid: true,
                            toaster: 'b-toaster-bottom-right'
                        });

                        this.getData();
                        this.$refs.vuetable.refresh();
                    })
                    .catch(err => {
                        this.$bvToast.toast(err, {
                            title: 'Error',
                            autoHideDelay: 2500,
                            variant: 'danger',
                            solid: true,
                            toaster: 'b-toaster-bottom-right'
                        });

                        console.log(err);
                    });
            }
        }
    }
</script>
