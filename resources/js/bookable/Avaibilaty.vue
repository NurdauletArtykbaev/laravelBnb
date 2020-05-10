<template>
    <div>
        <h6 class="text-uppercase text-secondary font-weight-bolder">
            Check Availability
            <span v-if="noAvailabity" class="text-danger">(Not Available)</span>
            <span v-if="hasAvailabity" class="text-success"
                >(Availabilable)</span
            >
        </h6>

        <div class="form-row">
            <div class="form-group col-md-6">
                <label for="from">From</label>
                <input
                    type="text"
                    name="from"
                    class="form-control form-control-sm"
                    v-model="from"
                    placeholder="Start date"
                    @keyup.enter="check"
                    :class="[{ 'is-invalid': this.errorFor('from') }]"
                />
                <!-- <div
                    class="invalid-feedback"
                    v-for="(error, index) in this.errorFor('from')"
                    :key="'from' + index"
                >
                    {{ error }}
                </div> -->
                <v-error :errors="errorFor('from')"></v-error>

            </div>
            <div class="form-group col-md-6">
                <label for="to">To</label>
                <input
                    type="text"
                    name="to"
                    class="form-control form-control-sm"
                    v-model="to"
                    placeholder="End date"
                    @keyup.enter="check"
                    :class="[{ 'is-invalid': this.errorFor('to') }]"
                />
                <!-- <div
                    class="invalid-feedback"
                    v-for="(error, index) in this.errorFor('to')"
                    :key="'to' + index"
                >
                    {{ error }}
                </div> -->
                <v-error :errors="errorFor('to')"></v-error>
            </div>
        </div>
        <button class="btn btn-secondary btn-block" @click="check">
            Check
        </button>
    </div>
</template>
<script>
import {is422, is404} from './../components/response'
export default {
    props: {
        bookableId: String
    },
    data() {
        return {
            from: null,
            to: null,
            loading: false,
            errors: null,
            status: null
        };
    },
    methods: {
        check() {
            this.loading = true;
            this.errors = null;

            axios
                .get(
                    `/api/bookables/${this.bookableId}/availability?from=${this.from}&to=${this.to}`
                )
                .then(res => {
                    this.status = res.status;
                })
                .catch(error => {
                    if (is422(error)) {
                        this.errors = error.response.data.errors;
                    }
                    this.status = error.response.status;
                })
                .then(() => (this.loading = false));
        },
        errorFor(field) {
            return this.hasErrors && this.errors[field]
                ? this.errors[field]
                : null;
        }
    },
    computed: {
        hasErrors() {
            return 422 === this.status && this.status !== null;
        },
        hasAvailabity() {
            return 200 === this.status;
        },
        noAvailabity() {
            return 404 === this.status;
        }
    }
};
</script>
<style scoped>
label {
    font-size: 0.7rem;
    color: gray;
    text-transform: uppercase;
    font-weight: bolder;
}

.is-invalid {
    border-color: #b22222;
    background-image: none;
}
.invalid-feedback {
    color: #b22222;
}
</style>
