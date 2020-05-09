<template>
    <div class="row">
        <div
            :class="[
                { 'col-md-4': loading || !alredyReviewed },
                { 'd-none': !loading && alredyReviewed }
            ]"
        >
            <div class="card">
                <div class="card-body">
                    <div v-if="loading">Loading.....</div>
                    <div v-else>
                        <p>
                            Stayed at
                            <router-link
                                :to="{
                                    name: 'bookable',
                                    params: { id: booking.bookable.bookable_id }
                                }"
                            >{{ booking.bookable.bookable_id}} {{booking.bookable.title}} {{ booking.bookable.description }}</router-link>
                        </p>
                        <p>{{ booking.from }} to {{ booking.to }}</p>
                    </div>
                </div>
            </div>
        </div>
        <div
            :class="[
                { 'col-md-8': loading || !alredyReviewed },
                { 'col-md-12': !loading && alredyReviewed }
            ]"
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
                    ></textarea>
                </div>
                <button class="btn btn-lg btn-primary btn-block">Submit</button>
            </div>
        </div>
        </div>
    </div>

    <!-- </div> -->
</template>
<script>
export default {
    data() {
        return {
            review: {
                rating: 5,
                content: null,
                loading: false,
                existReview: null
            },
            loading: false,
            existingReview: null,
            booking: null
        };
    },
    // methods:{
    //     onRatingChanged(rating){
    //         console.log(rating);
    //     },
    // }
    created() {
        this.loading = true;
        //1. If review already exists (in rewviews table by id)
        axios
            .get(`/api/reviews/${this.$route.params.id}`)
            .then(response => {
                (this.existingReview = response.data),
                    console.loading(this.existingReview);
            })
            .catch(error => {
                if (
                    error.response &&
                    error.response.status &&
                    404 === error.response.status
                ) {
                    //2. Fetch a booking by a review key
                    return axios
                        .get(`/api/booking-by-review/${this.$route.params.id}`)
                        .then(response => {
                            this.booking = response.data;
                        });
                }
            })
            .then(response => (this.loading = false));
        //3. Store the review
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
        }
    }
};
</script>
