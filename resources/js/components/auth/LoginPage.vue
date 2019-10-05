<template>
    <b-card header="Login" style="width: 400px;">
        <b-form class="bg-light">
            <b-form-group id="email" label="Email:" label-for="input-email">
                <b-form-input id="input-email" v-model="form.email" type="email" required placeholder="Enter email"></b-form-input>
            </b-form-group>

            <b-form-group id="password" label="Password:" label-for="input-password">
                <b-form-input id="input-password" v-model="form.password" type="password" required placeholder="Enter password"></b-form-input>
            </b-form-group>

            <b-button type="button" @click="login" variant="primary">Login</b-button>
        </b-form>
    </b-card>
</template>

<script>
    import { login } from '../../services/api/auth';

    export default {
        name: 'LoginPage',
        data() {
            return {
                form: {
                    email: '',
                    password: ''
                }
            }
        },
        methods: {
            login() {
                this.$store.dispatch('login');
                login(this.$data.form)
                    .then(res => {
                        console.log(res);

                        this.$store.commit('loginSuccess', res);
                        this.$router.push({ path: '/admin' });
                    })
                    .catch(error => {
                        console.log(error);

                        this.$store.commit('loginFail', { error });

                        this.$bvToast.toast(`Wrong email or password!`, {
                            title: 'Login error',
                            autoHideDelay: 2500,
                            variant: 'danger',
                            solid: true,
                            toaster: 'b-toaster-bottom-right'
                        })
                    });
            }
        }
    }
</script>
