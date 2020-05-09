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
                <avaibality :bookable-id="this.$route.params.id"></avaibality>
            </div>
        </div>
    </div>
</template>
<script>
import Avaibality from "./Avaibilaty";
import ReviewList from "./ReviewList";
export default {
    props: {
        bookableId: String
    },
    data() {
        return {
            bookable: null,
            loading: false
        };
    },
    components: {
        Avaibality,
        ReviewList
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
    }
};
</script>
