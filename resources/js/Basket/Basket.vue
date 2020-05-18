<template>
<div>
    <success v-if="success">
        Congratulations on your purchase
    </success>
<div class="row" v-else>
        <div class="col-md-8" v-if="itemsInBasket">
            <div class="row">
                <div class="col-md-6 form-group">
                    <label for="first_name">First name</label>
                    <input
                        type="text"
                        class="form-control"
                        name="first_name"
                        v-model="customer.first_name"
                        placeholder="First name"
                        :class="[{'is-invalid':errorFor('customer.last_name')}]"
                    />
                    <v-error :errors="errorFor('customer.last_name')"></v-error>
                </div>
                 <div class="col-md-6 form-group">
                    <label for="last_name">Last name</label>
                    <input
                        type="text"
                        class="form-control"
                        name="last_name"
                        v-model="customer.last_name"
                        placeholder="Last name"
                        :class="[{'is-invalid':errorFor('customer.last_name')}]"
                    />
                    <v-error :errors="errorFor('customer.last_name')"></v-error>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12 form-group">
                    <label for="email">Email</label>
                    <input
                        type="email"
                        class="form-control"
                        name="email"
                        v-model="customer.email"
                        :class="[{'is-invalid':errorFor('customer.email')}]"

                    />
                    <v-error :errors="errorFor('customer.email')"></v-error>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6 form-group">
                    <label for="street">Street</label>
                    <input type="text" class="form-control" name="street"  
                    v-model="customer.street"
                    :class="[{'is-invalid':errorFor('customer.street')}]"
                    >
                    <v-error :errors="errorFor('customer.street')"></v-error>
                </div>
                <div class="col-md-6 form-group">
                    <label for="city">City</label>
                    <input type="text" class="form-control" name="city" v-model="customer.city"
                    :class="[{'is-invalid':errorFor('customer.city')}]">
                    <v-error :errors="errorFor('customer.city')"></v-error>

                </div>
            </div>

            <div class="row">
                <div class="col-md-6 form-group">
                    <label for="country">Country</label>
                    <input type="text" class="form-control" name="country" 
                    v-model="customer.country"
                    :class="[{'is-invalid':errorFor('customer.country')}]"
                    >
                    <v-error :errors="errorFor('customer.country')"></v-error>
                </div>
                <div class="col-md-4 form-group">
                    <label for="state">State</label>
                    <input type="text" class="form-control" name="state" v-model="customer.state" 
                    :class="[{'is-invalid':errorFor('customer.state')}]"
                    >
                    <v-error :errors="errorFor('customer.state')"></v-error>
                </div>
                <div class="col-md-2 form-group">
                    <label for="zip">Zip</label>
                    <input type="text" class="form-control" name="zip" v-model="customer.zip" 
                    :class="[{'is-invalid':errorFor('customer.zip')}]"
                    >
                    <v-error :errors="errorFor('customer.zip')"></v-error>
                </div>
            </div>
            <hr/>
            <div class="row">
                <div class="col-md-12 form-group">
                    <button type="submit" @click.prevent="book" 
                    class="btn btn-lg btn-primary btn-block"
                    :disabled="loading">Book now!</button>
                </div>
            </div>

        </div>
        <div class="col-md-8" v-else>
            <div class="jumbotron jumbotron-fluid text-center">
                <h1>Empty</h1>
            </div>

        </div>
        <div class="col-md-4">
            <div class="d-flex justify-content-between">
                <h6 class="text-uppercase text-secondary font-weight-bolder">
                    Your cart
                </h6>
                <h6 class="badge badge-secondary text-uppercase">
                    <span v-if="itemsInBasket">Items {{ itemsInBasket }}</span>
                    <span v-else>Empty</span>
                </h6>
            </div>
            <transition-group name="fade">
                <div v-for="item in basket" :key="item.bookable.id">
                    <div
                        class="pt-2 pb-2 border-top d-flex justify-content-between"
                    >
                        <router-link
                            :to="{
                                name: 'bookable',
                                params: { id: item.bookable.id }
                            }"
                        >
                            {{ item.bookable.title }}
                        </router-link>
                        <span class="font-weight-bold">{{
                            item.price.total
                        }}</span>
                    </div>

                    <div class="pt-2 pb-2  d-flex justify-content-between">
                        <span>From {{ item.dates.from }}</span>

                        <span>To {{ item.dates.to }}</span>
                    </div>
                    <div class="pt-2 pb-2  text-right">
                        <button
                            class="btn btn-sm btn-outline-secondary"
                            @click="
                                $store.dispatch(
                                    'removeFromBasket',
                                    item.bookable.id
                                )
                            "
                        >
                            <i class="fas fa-trash-alt"></i>
                        </button>
                    </div>
                </div>
            </transition-group>
        </div>
    </div>
</div>
    
</template>
<script>
import { mapGetters, mapState } from "vuex";
import validationError from './../shared/mixins/validationError'
export default {
    mixins:[validationError],
    data(){
        return {
            loading: false,
            customer:{
                first_name:null,
                last_name: null,
                email: null,
                street: null,
                city: null,
                country: null,
                state: null,
                zip: null,
            },
            bookingAttempted: false,
        }
    },
    computed: {
        ...mapGetters(["itemsInBasket"]),
        ...mapState({
            basket: state => state.basket.items
        }),
        success(){
            return !this.loading && 0 === this.itemsInBasket && this.bookingAttempted
        }
    },
    methods:{
        async book(){
            this.loading = true
            this.bookingAttempted = false
            this.errors = null

            try{
                await axios.post('/api/checkout', 
                    {
                        customer: this.customer, 
                        bookings: this.basket.map(basketItem=>({
                        bookable_id: basketItem.bookable.id,
                        from: basketItem.dates.from,
                        to:basketItem.dates.to}))})

                        this.$store.dispatch('clearBasket')
                        this.bookingAttempted =true


            } catch (error){
                this.errors = error.response && error.response.data.errors;

            }

            this.loading = false

        }
    }
};
</script>
<style scoped>
h6.badge {
    font-size: 100%;
}

a {
    color: black;
}
</style>
