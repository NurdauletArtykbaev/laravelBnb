<template>
    <div>
        <div class="row">
            <div class="col-md-8 pb-4">
                <div v-if="loading">
                    <h1>Loading.....</h1>
                </div>
                <div class="card" v-else>
                    <div class="card-body">
                        <h5 class="card-title">{{ bookable.title }}</h5>
                        <hr/>
                        <article>{{ bookable.description }}</article>
                    </div>
                </div>
                <review-list :bookable-id="this.$route.params.id"></review-list>
            </div>
            <div class="col-md-4 pb-4">
                <avaibality :bookable-id="this.$route.params.id" @availability="checkPrice($event)" class="mb-4"></avaibality>
                <transition name="fade">
                    <price-breakdown  v-if="price" :price="price"></price-breakdown>
                </transition>
                <transition name="fade">
                    <button v-if="price" class="btn btn-outline-secondary btn-block" @click="addToBasket" :disabled='inBasketAlready'>Book now</button>
                </transition>
                <transition name="fade">
                    <button v-if="inBasketAlready" class="btn btn-outline-secondary btn-block" @click="removeFromBasket">Remove</button>
                </transition>

                <div v-if="inBasketAlready" class="mt-4 text-muted warning">
                    Seems like you've added this object to basket already. If you  want  to change dates, remove from the basket first.
                </div>

            </div>
        </div>
    </div>
</template>
<script>
import Avaibality from "./Avaibilaty";
import ReviewList from "./ReviewList";
import PriceBreakdown from "./PriceBreakdown";

import {mapState} from 'vuex';

export default {
    props: {
        bookableId: [String, Number]
    },
    data() {
        return {
            bookable: null,
            loading: false,
            price: null

        };
    },
    components: {
        Avaibality,
        ReviewList,
        PriceBreakdown
    },
    created() {
        (this.loading = true),
            // console.log(this.$route.params.id)

            // axios.get(`/api/bookables/${this.$route.params.id}`)
            axios
                .get(`/api/bookables/${this.$route.params.id}`)

                .then(res => {
                    // setTimeout(()=> {
                    this.bookable = res.data;
                    this.loading = false;
                    // }, 3000);
                })
                .catch(error => console.log(error));
    },
    computed: {
        ...mapState({
            lastSearch: "lastSearch",
            inBasketAlready(state){
                if(null === this.bookable)
                    return false;

                return this.$store.getters.inBasketAlready(this.bookable.id);
                // return state.basket.items.reduce((result, item) => result || this.bookable.id, false)
        }})
    },

    methods:{
        async checkPrice(hasAvailabity){
            if(!hasAvailabity){
                this.price = null;
                return
            }

            try{
                this.price =
                 (await axios.get(`/api/bookables/${this.bookable.id}/price?from=${this.lastSearch.from}&to=${this.lastSearch.to}`)).data.data
            } catch(err){
                this.price = null
            }
        },
        addToBasket(){
            this.$store.dispatch('addToBasket',{
                bookable: this.bookable,
                price: this.price,
                dates: this.lastSearch
            })
        },
        removeFromBasket(){
            this.$store.dispatch("removeFromBasket", this.bookable.id)
        }
    },

};
</script>

<style scoped>
.warning{
    font-size: 0,7rem;
}
</style>
