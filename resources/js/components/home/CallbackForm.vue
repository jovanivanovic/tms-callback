<template>
    <b-form>
        <b-container fluid>
            <b-row>
                <b-col>
                    <b-form-group id="name" label="Name: (required)" label-for="name-input"
                          :invalid-feedback="errors.name ? errors.name[0] : ''"
                          :valid-feedback="''"
                          :state="getInputState('name')">
                        <b-form-input :state="getInputState('name')" id="name-input" v-model="form.name" type="text" required placeholder="Enter your name"></b-form-input>
                    </b-form-group>

                    <b-form-group id="gender" label="Gender: (required)" label-for="gender-input"
                          :invalid-feedback="errors.gender ? errors.gender[0] : ''"
                          :valid-feedback="''"
                          :state="getInputState('gender')">
                        <b-form-select :state="getInputState('gender')" id="gender-input" v-model="form.gender" required :options="fields.gender"></b-form-select>
                    </b-form-group>

                    <b-form-group id="phone" label="Phone: (required)" label-for="phone-input"
                          :invalid-feedback="errors.phone ? errors.phone[0] : ''"
                          :valid-feedback="''"
                          :state="getInputState('phone')">
                        <b-form-input :state="getInputState('phone')" id="phone-input" v-model="form.phone" type="text" required placeholder="Enter your phone number"></b-form-input>
                    </b-form-group>

                    <b-form-group id="order-number" label="Order Number:" label-for="order-number-input"
                          :invalid-feedback="errors.order_number ? errors.order_number[0] : ''"
                          :valid-feedback="''"
                          :state="getInputState('order_number')">
                        <b-form-input :state="getInputState('order_number')" id="order-number-input" v-model="form.order_number" type="text" placeholder="Enter the order number"></b-form-input>
                    </b-form-group>

                    <b-form-group id="email" label="Email:" label-for="email-input"
                          :invalid-feedback="errors.email ? errors.email[0] : ''"
                          :valid-feedback="''"
                          :state="getInputState('email')">
                        <b-form-input :state="getInputState('email')" id="email-input" v-model="form.email" type="email" required placeholder="Enter your email"></b-form-input>
                    </b-form-group>
                </b-col>
                <b-col>
                    <b-form-group id="issue" label="Issue / Description: (required)" label-for="issue-input"
                          :invalid-feedback="errors.issue ? errors.issue[0] : ''"
                          :valid-feedback="''"
                          :state="getInputState('issue')">
                        <b-form-textarea :state="getInputState('issue')" id="issue-input" v-model="form.issue" required placeholder="Enter your issue here..." rows="8" max-rows="10"></b-form-textarea>
                    </b-form-group>

                    <b-form-group id="callback-date" label="Callback Date: (required)" label-for="callback-date-input"
                          :invalid-feedback="errors.callback_date ? errors.callback_date[0] : ''"
                          :valid-feedback="''"
                          :state="getInputState('callback_date')">
                        <date-picker :state="getInputState('callback_date')" id="callback-date-input" v-model="form.callback_date" :config="fields.date"></date-picker>
                    </b-form-group>

                    <b-form-group id="callback-time" label="Callback Time: (required)" label-for="callback-time-input"
                          :invalid-feedback="errors.callback_time ? errors.callback_time[0] : ''"
                          :valid-feedback="''"
                          :state="getInputState('callback_time')">
                        <b-form-select :state="getInputState('callback_time')" :disabled="fields.time == null" id="callback-time-input" v-model="form.callback_time" required :options="fields.time ? fields.time : []"></b-form-select>
                    </b-form-group>
                </b-col>
            </b-row>
        </b-container>
    </b-form>
</template>

<script>
    import datePicker from 'vue-bootstrap-datetimepicker';
    import { getAvailableTimes } from "../../services/api/callback";

    export default {
        name: 'CallbackForm',
        data() {
            return {
                fields: {
                    gender: [
                        {
                            text: 'Select your gender',
                            value: null,
                        },
                        {
                            text: 'Male',
                            value: 0,
                        },
                        {
                            text: 'Female',
                            value: 1,
                        }
                    ],
                    date: {
                        format: 'DD/MM/YYYY',
                        daysOfWeekDisabled: [ 0 ]
                    },
                    time: null
                },
                form: {
                    name: null,
                    gender: null,
                    phone: null,
                    order_number: null,
                    email: null,
                    issue: null,
                    callback_date: null,
                    callback_time: null
                }
            }
        },
        props: {
            errors: {}
        },
        computed: {
            computedDate() {
                return this.form.callback_date;
            }
        },
        methods: {
            getAvailableTimes() {
                getAvailableTimes(this.form.callback_date)
                    .then((response) => {
                        this.fields.time = response;
                        this.form.callback_time = response[0];
                    });
            },
            getInputState(input) {
                if (this.errors[input] == null || this.errors[input] === undefined) {
                    return null
                } else {
                    return false;
                }
            }
        },
        watch: {
            form: {
                handler: function () {
                    this.$emit('form', this.form);
                },
                deep: true
            },
            computedDate: {
                handler: function () {
                    this.getAvailableTimes();
                }
            }
        },
        components: {
            datePicker
        }
    }
</script>
