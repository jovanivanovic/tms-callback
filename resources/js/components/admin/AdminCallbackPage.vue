<template>
    <div>
        <b-card style="width: 800px;">
            <template v-slot:header>
                <router-link class="" to="/admin" exact>Administration</router-link> / {{ callback.name }} <b-badge variant="primary">{{ callback.id }}</b-badge>

                <b-button size="sm" variant="outline-danger" class="pull-right" @click="archiveCallback"><i class="fa fa-archive"></i></b-button>
            </template>
            <b-row>
                <b-col>
                    <b-form-group>
                        <label><b>Name:</b></label>
                        <p>{{ callback.name }}</p>
                    </b-form-group>

                    <b-form-group>
                        <label><b>Gender:</b></label>
                        <p>{{ callback.gender === 0 ? 'Male' : 'Female' }}</p>
                    </b-form-group>

                    <b-form-group>
                        <label><b>Phone:</b></label>
                        <p>{{ callback.phone }}</p>
                    </b-form-group>
                </b-col>
                <b-col>
                    <b-form-group>
                        <label><b>Order Number:</b></label>

                        <p v-if="callback.order_number">{{ callback.order_number }}</p>
                        <p v-else><b-badge variant="danger">n/a</b-badge></p>
                    </b-form-group>

                    <b-form-group>
                        <label><b>Email:</b></label>

                        <p v-if="callback.email">{{ callback.email }}</p>
                        <p v-else><b-badge variant="danger">n/a</b-badge></p>
                    </b-form-group>

                    <b-form-group>
                        <label><b>Callback Date and Time:</b></label>
                        <p>{{ parseDate(callback.datetime).format('ddd, MMMM Do YYYY, h:mm:ss a') }}</p>
                    </b-form-group>
                </b-col>
            </b-row>
            <b-row>
                <b-col>
                    <b-form-group>
                        <label><b>Issue / Description:</b></label>
                        <p>{{ callback.issue }}</p>
                    </b-form-group>
                </b-col>
            </b-row>
        </b-card>

        <b-card style="margin-top: 20px; width: 800px">
            <template v-slot:header>
                Comments <b-badge variant="primary">{{ callback.comments ? callback.comments.length : 0 }}</b-badge>
            </template>

            <b-form-group>
                <b-form-textarea id="comment-input" v-model="form.comment" required placeholder="Enter your comment here..." rows="3" max-rows="10"></b-form-textarea>

                <b-button size="sm" variant="outline-primary" class="mt-2 pull-right" @click="sendComment">Post <i class="fa fa-send"></i></b-button>
            </b-form-group>

            <b-list-group>
                <b-list-group-item v-for="comment in callback.comments" v-bind:key="comment.id" class="flex-column align-items-start">
                    <p class="mb-1">{{ comment.content }}</p>

                    <div class="d-flex w-100 justify-content-between">
                        <small class="text-muted">{{ comment.user.name }}</small>
                        <small class="text-muted">{{ parseDate(comment.created_at).fromNow() }}</small>
                    </div>
                </b-list-group-item>
            </b-list-group>
        </b-card>
    </div>
</template>

<script>
    import { getCallback, commentCallback, archiveCallback } from "../../services/api/admin";
    import moment from 'moment';

    export default {
        name: 'AdminCallbackPage',
        data() {
            return {
                callback: {},
                form: {}
            }
        },
        methods: {
            parseDate(date) {
                return moment(date, "YYYY-MM-DD HH:mm:ss");
            },
            sendComment() {
                commentCallback(this.$route.params.id, this.form.comment)
                    .then(res => {
                        this.callback.comments = res.comments;
                        this.form = {};

                        this.$bvToast.toast(res.message, {
                            title: 'Posted',
                            autoHideDelay: 2500,
                            variant: 'success',
                            solid: true,
                            toaster: 'b-toaster-bottom-right'
                        });
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
            },
            archiveCallback() {
                archiveCallback(this.callback.id)
                    .then(res => {
                        this.$bvToast.toast(res.message, {
                            title: 'Archived',
                            autoHideDelay: 2500,
                            variant: 'success',
                            solid: true,
                            toaster: 'b-toaster-bottom-right'
                        });

                        this.$router.push({ path: `/admin` });
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
        },
        mounted() {
            getCallback(this.$route.params.id)
                .then(res => {
                    this.callback = res;
                })
                .catch(err => {
                    console.log(err);
                });
        }
    }
</script>
