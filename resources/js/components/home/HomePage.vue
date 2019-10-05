<template>
    <div class="HomePage">
        <div class="flex-container">
            <div class="flex body">
                <img class="logo" src="/img/logo-white.svg">
                <h3>PHP/Full-Stack Developer Assessment</h3>
                <p>Author: <a class="text-info" target="_blank" href="https://git.einu.net/jovanivanovic">Jovan Ivanovic</a></p>

                <b-button size="lg" variant="outline-light" @click="toggleModal">Show Callback Form</b-button>
                <router-link class="btn btn-outline-success btn-lg" to="/admin" exact>Administration</router-link>

                <p class="mt-3">Based on: <a class="text-danger" target="_blank" href="/files/instructions.pdf">instructions.pdf</a></p>
            </div>
        </div>

        <b-modal centered ref="callback-modal" size="lg" v-model="modal.open">
            <template v-slot:modal-header="{ close }">
                <b>Callback Form</b>
            </template>

            <template v-slot:default="{ hide }">
                <template v-if="form.success">
                    <div class="success">
                        <svg id="successAnimation" class="animated" xmlns="http://www.w3.org/2000/svg" width="300" height="300" viewBox="0 0 70 70">
                            <path id="successAnimationResult" fill="#D8D8D8" d="M35,60 C21.1928813,60 10,48.8071187 10,35 C10,21.1928813 21.1928813,10 35,10 C48.8071187,10 60,21.1928813 60,35 C60,48.8071187 48.8071187,60 35,60 Z M23.6332378,33.2260427 L22.3667622,34.7739573 L34.1433655,44.40936 L47.776114,27.6305926 L46.223886,26.3694074 L33.8566345,41.59064 L23.6332378,33.2260427 Z"/>
                            <circle id="successAnimationCircle" cx="35" cy="35" r="24" stroke="#979797" stroke-width="2" stroke-linecap="round" fill="transparent"/>
                            <polyline id="successAnimationCheck" stroke="#979797" stroke-width="2" points="23 34 34 43 47 27" fill="transparent"/>
                        </svg>

                        <h2>Thank you for your submission!</h2>
                        <p>We will get in touch with you soon.</p>
                    </div>
                </template>
                <CallbackForm v-if="!form.success" :errors="form.errors" @form="handleFormData($event)" />
            </template>

            <template v-slot:modal-footer="{ ok }">
                <b-container fluid>
                    <b-row no-gutters>
                        <b-col class="align-left">
                            <b-form-group v-if="!form.success"
                                          :invalid-feedback="''"
                                          :valid-feedback="''"
                                          :state="getInputState('terms')">
                                <b-form-checkbox
                                    id="terms"
                                    :state="getInputState('terms')"
                                    v-model="form.data.terms"
                                    name="terms"
                                    value="yes"
                                    unchecked-value="no"
                                >
                                    I agree to the Terms and Conditions
                                </b-form-checkbox>
                            </b-form-group>
                        </b-col>
                        <b-col class="align-right">
                            <b-button v-if="!form.success" size="sm" variant="success" @click="submitData">Submit</b-button>
                            <b-button v-if="form.success" size="sm" variant="primary" @click="toggleModal">Close</b-button>
                        </b-col>
                    </b-row>
                </b-container>
            </template>
        </b-modal>
    </div>
</template>

<style>
    .align-left { text-align: left; }
    .align-right { text-align: right; }

    .container-fluid {
        padding: 0;
    }
</style>

<script>
    import CallbackForm from './CallbackForm'
    import { submitCallback } from "../../services/api/callback";

    export default {
        name: 'HomePage',
        data: () => {
            return {
                modal: {
                    open: false
                },
                form: {
                    terms: null,
                    errors: {},
                    data: {},
                    success: false,
                }
            }
        },
        methods: {
            toggleModal() {
                this.modal.open = !this.modal.open;
            },
            handleFormData(e) {
                this.form.data = e;
            },
            submitData() {
                submitCallback(this.form.data)
                    .then((response) => {
                        this.form.success = true;
                        this.form.errors = {};

                        console.log(response);
                    })
                    .catch((err) => {
                        this.form.errors = err.response.data.errors;
                    });
            },
            getInputState(input) {
                if (this.form.errors[input] == null || this.form.errors[input] === undefined) {
                    return null
                } else {
                    return false;
                }
            }
        },
        components: {
            CallbackForm
        },
        mounted() {
            this.toggleModal();
        }
    }
</script>
