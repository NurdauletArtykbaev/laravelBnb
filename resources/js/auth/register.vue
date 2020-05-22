<template>
    <div class="w-50 m-auto">
        <div class="card card-body">
            <form>
                <div class="form-group">
                    <label for="name">Name</label>
                    <input
                        type="text"
                        class="form-control"
                        name="name"
                        placeholder="Enter your Name"
                        :class="[{ 'is-invalid': errorFor('name') }]"
                        v-model="email"
                    />
                    <v-error :errors="errorFor('name')"></v-error>
                </div>
                <div class="form-group">
                    <label for="email">E-mail</label>
                    <input
                        type="email"
                        class="form-control"
                        name="email"
                        placeholder="Enter your Email"
                        :class="[{ 'is-invalid': errorFor('email') }]"
                        v-model="email"
                    />
                    <v-error :errors="errorFor('email')"></v-error>
                </div>
                <div class="form-group">
                    <label for="password">Password</label>
                    <input
                        type="password"
                        class="form-control"
                        name="password"
                        placeholder="Enter your password"
                        :class="[{ 'is-invalid': errorFor('password') }]"
                        v-model="password"
                    />
                    <v-error :errors="errorFor('password')"> </v-error>
                </div>
                <div class="form-group">
                    <label for="password_confirmation">Re-type Password</label>
                    <input
                        type="password"
                        class="form-control"
                        name="password_confirmation"
                        placeholder="Confirm your password"
                        :class="[{ 'is-invalid': errorFor('password_confirmation') }]"
                        v-model="password"
                    />
                    <v-error :errors="errorFor('password_confirmation')"> </v-error>
                </div>
            </form>
            <button
                class="btn btn-primary btn-lg btn-block"
                :disabled="loading"
                @click.prevent="register"
            >
                Log-in
            </button>
            <hr />
            <span
                >Already have ann account?
                <router-link :to="{ name: 'login' }" class="font-weight-bold"
                    >Log-In</router-link
                >
            </span>

        </div>
    </div>
</template>
<script>
import validationError from "../shared/mixins/validationError";
import {logIn} from "../shared/utils/auth"

export default {
    mixins: [validationError],
    data() {
        return {
            user: {
                name: null,
                email: null,
                password: null,
                password_confirmation: null,
            },
            loading: false
        };
    },
    methods: {
        async register() {
            this.loading = true;
            this.errors = null;
            try {
                await axios.get("/sanctum/csrf-cookie").then(response => {
                    // Login...
                });
                await axios.post("/register", {

                    email: this.email,
                    password: this.password
                });
                // await axios.get("/user");
                logIn()
                this.$store.dispatch('loadUser')
                this.$router.push({name: 'home'})
            } catch (error) {
                this.errors = error.response && error.response.data.errors;
            }
            this.loading = false;
        }
    }
};
</script>
