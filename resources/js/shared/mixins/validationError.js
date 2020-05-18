export default{
    data(){
        return {errors: null};
    },
    methods:{
        errorFor(field) {
            console.log('errors',null !== this.errors && this.errors[field]
            ? this.errors[field]
            : null)
            return null !== this.errors && this.errors[field]
                ? this.errors[field]
                : null;
        }
    }
}