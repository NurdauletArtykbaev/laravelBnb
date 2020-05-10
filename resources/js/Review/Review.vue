<template>
    <div>
        <fatal-error v-if="error"></fatal-error>
        <div class="row" v-else>
            <div :class="[{ 'col-md-4': oneColumn }, { 'd-none': twoColumn }]">
                <div class="card">
                    <div class="card-body">
                        <div v-if="loading">Loading.....</div>
                        <div v-if="hasBooking">
                            <p>
                                Stayed at
                                <router-link
                                    :to="{
                                        name: 'bookable',
                                        params: {
                                            id: booking.bookable.bookable_id
                                        }
                                    }"
                                    >{{ booking.bookable.bookable_id }}
                                    {{ booking.bookable.title }}
                                    {{
                                        booking.bookable.description
                                    }}</router-link
                                >
                            </p>
                            <p>{{ booking.from }} to {{ booking.to }}</p>
                        </div>
                    </div>
                </div>
            </div>
            <div
                :class="[{ 'col-md-8': oneColumn }, { 'col-md-12': twoColumn }]"
            >
                <div v-if="loading">
                    <h3>Loading....</h3>
                </div>
                <div v-else>
                    <div v-if="alredyReviewed">
                        <h3>
                            You've alredy left a review for this booking!
                        </h3>
                    </div>
                    <div v-else>
                        <div class="form-group">
                            <label class="text-muted"
                                >Select the star (1 is wonst - 5 is best)</label
                            >
                            <!-- <star-rating :rating='5' class="fa-3x" v-on:rating:changed="onRatingChanged"></star-rating> -->
                            <!-- <star-rating 
                        :value='review.rating' class="fa-3x" v-on:input="review.rating = $event">
                        </star-rating> -->
                            <star-rating class="fa-3x" v-model="review.rating">
                            </star-rating>
                        </div>
                        <div class="form-group">
                            <label for="content" class="text-muted"
                                >Describe your expirience with</label
                            >
                            <textarea
                                name="content"
                                cols="30"
                                rows="10"
                                class="form-control"
                                v-model="review.content"
                                :class="[{ 'is-invalid': errorFor('content') }]"
                            ></textarea>
                            <!-- <div>
                            <div
                                class="invalid-feedback"
                                v-for="(error, index) in errorFor('content')"
                                :key="'content' + index"
                            >
                                {{ error }}
                            </div>
                            </div> -->
                            <v-error :errors="errorFor('content')"></v-error>
                        
                        </div>

                        <button
                            class="btn btn-lg btn-primary btn-block"
                            @click.prevent="submit"
                            :disabled="sending"
                        >
                            Submit
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- </div> -->
</template>
<script>
import { is404, is422 } from "./../components/response";
import ValidationError from './../shared/mixins/validationError'
export default {
    mixins:[ValidationError],
    data() {
        return {
            review: {
                id: null,
                rating: 5,
                content: null
            },
            loading: false,
            existingReview: null,
            booking: null,
            error: false,
            // errors: null,
            sending: false
        };
    },
    // methods:{
    //     onRatingChanged(rating){
    //         console.log(rating);
    //     },
    // }
    created() {
        this.review.id = this.$route.params.id;
        this.loading = true;
        //1. If review already exists (in rewviews table by id)
        axios
            .get(`/api/reviews/${this.review.id}`)
            .then(response => {
                this.existingReview = response.data;
            })
            .catch(err => {
                if (is404(err)) {
                    //2. Fetch a booking by a review key
                    return axios
                        .get(`/api/booking-by-review/${this.review.id}`)
                        .then(response => {
                            this.booking = response.data;
                        })
                        .catch(err => {
                            this.error = !is404(err);
                        });
                }
                this.error = true;
            })
            .then(response => (this.loading = false));
    },
    computed: {
        alredyReviewed() {
            return this.hasReview || !this.booking;
        },
        hasReview() {
            return this.existingReview !== null;
        },
        hasBooking() {
            return this.booking !== null;
        },
        oneColumn() {
            return this.loading || !this.alredyReviewed;
        },
        twoColumn() {
            return !this.loading && this.alredyReviewed;
        }
    },
    methods: {
        submit() {
            //3. Store the review
            this.errors = null;
            this.sending = true;
            axios
                .post(`/api/reviews`, this.review)
                .then(res => console.log(res))
                .catch(err => {
                    if (is422(err)) {
                        const errors = err.response.data.errors;
                        if (errors["content"] && 1 === _.size(errors)) {
                            this.errors = errors;
                            return;
                        }
                    }
                    this.error = true;
                })
                .then(() => (this.sending = false));
        },
        //mixins validationError
        // errorFor(field) {
        //     return null !== this.errors && this.errors[field]
        //         ? this.errors[field]
        //         : null;
        // }
    }
};
</script>

<style scoped>
.form-control.is-invalid ~div > .invalid-feedback{
    display: block;
}
</style>
