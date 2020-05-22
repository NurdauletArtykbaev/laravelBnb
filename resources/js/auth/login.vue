<template>
    <div class="w-50 m-auto">
        <div class="card card-body">
            <form>
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
            </form>
            <button
                class="btn btn-primary btn-lg btn-block"
                :disabled="loading"
                @click.prevent="login"
            >
                Log-in
            </button>
            <hr />
            <span
                >No account?
                <router-link :to="{ name: 'home' }" class="font-weight-bold"
                    >Register</router-link
                >
            </span>
            <span
                >Forgotten password?
                <router-link :to="{ name: 'home' }" class="font-weight-bold"
                    >Reset password</router-link
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
            email: null,
            password: null,
            loading: false
        };
    },
    methods: {
        async login() {
            this.loading = true;
            this.errors = null;
            try {
                await axios.get("/sanctum/csrf-cookie").then(response => {
                    // Login...
                });
                await axios.post("/login", {
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
