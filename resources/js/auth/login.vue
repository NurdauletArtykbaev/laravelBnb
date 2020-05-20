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
                    />
                    <label for="password">Password</label>
                    <input
                        type="password"
                        class="form-control"
                        name="password"
                        placeholder="Enter your password"
                    />
                </div>
            </form>
            <button class="btn btn-primary btn-lg btn-block">Log-in</button>
            <hr/>
            <span>No account? 
                <router-link :to="{name:'home'}" class="font-weight-bold">Register</router-link>
            </span>
            <span>Forgotten password? 
                <router-link :to="{name:'home'}" class="font-weight-bold">Reset password</router-link>
            </span>
        </div>
    </div>
</template>
<script>
export default {
    data() {
        return {
            email: null,
            password: null
        };
    }
};
</script>
