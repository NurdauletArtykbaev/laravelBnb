<template>
    <div>
        <!-- <bookable></bookable> -->
        <!-- <BookableListItem></BookableListItem> -->

        <!-- <bookable-list-item></bookable-list-item> -->

        <!-- <bookable-list-item title='Cheap Villa' content='Very cheap villa'></bookable-list-item> -->

        <!-- <bookable-list-item
            item-title="Cheap Villa"
            item-content="Very cheap villa"
            :item-price="1000"
        ></bookable-list-item> -->

        <!-- <bookable-list-item v-if="bookable1 != null"
            :item-title="bookable1.title"
            :item-content="bookable1.content"
            :item-price='1000'
        ></bookable-list-item>

            <bookable-list-item v-if="bookable2 != null"
            :item-title="bookable2.title"
            :item-content="bookable2.content"
            :item-price="1000"
        ></bookable-list-item> -->
        <h1>Rouws is {{ rows }}</h1>
        <div v-if="loading">
            <h1>data loading ....</h1>
        </div>
        <div v-else>
            <div class="row mb-4" v-for="row in rows" :key="'row' + row">
                <div class="col d-flex align-items-stretch" v-for="(bookable, column) in bookablesRows(row)" :key="'row' + row + column">
                    <!-- <bookable-list-item 
                        :item-title="bookable.title"
                        :item-description="bookable.description"
                        :item-price="1000"
                    ></bookable-list-item>   -->
                    <bookable-list-item v-bind="bookable"
                    ></bookable-list-item>  
                    
                </div>
               <div class="col" v-for="p in placeholdersInRow(row)" :key="'placeholder' + row + p">
                   <!-- <p>{{p}}</p> -->
               </div>

            </div>
        <!-- <bookable-list-item 
            :item-title="bookable.title"
            :item-content="bookable.content"
            :item-price="1000"
            v-for="(bookable, index) in bookables"
            :key="index"
        ></bookable-list-item>  -->
        </div>

    </div>
</template>
<script>
import BookableListItem from "./BookableListItem";
export default {
    components: {
        // 'bookable': BookableListItem
        BookableListItem
    },
    data(){
        return{
            // bookable1: null,
            // bookable2: null,
            bookables: null,
            loading: false,
            columns: 3,

        }
    },
    computed:{
        rows(){
            return this.bookables == null ? 0 : Math.ceil(this.bookables.length/this.columns)
        }
    },
    methods:{
        bookablesRows(row){
            return this.bookables.slice((row-1) * this.columns, row * this.columns)
        },
        placeholdersInRow(row){
            return this.columns - this.bookablesRows(row).length
        }
    },
    created(){
        this.loading = true;

   
        // setTimeout(()=>{
        //     this.bookable1= {
        //         title: 'Cheap villa 1',
        //         content: 'Very cheap villa 1',
        //     }
        //     this.bookable2= {
        //         title: 'Cheap villa 2',
        //         content: 'Very cheap villa 2',
        //     }
        //     //     this.bookable2= {
        //     //     title: 'Cheap villa 2',
        //     //     content: 'Very cheap villa 2'
        //     // }
        // }, 3000),

        // setTimeout(()=>{
        //     this.bookable2= {
        //         title: 'setTimeout 2 Cheap villa 2',
        //         content: 'setTimeout 2 Very villa 2'
        //     }
        //     //     this.bookable2= {
        //     //     title: 'Cheap villa 2',
        //     //     content: 'Very cheap villa 2'
        //     // }
        // }, 5000)
        // setTimeout(()=>{
        //     this.bookables= [
        //         {
        //             title: 'setTimeout 1 Cheap villa 1',
        //             content: 'setTimeout 1 Very villa 1'
        //             },
        //         {
        //             title: 'Cheap villa 2',
        //             content: 'Very cheap villa 2'
        //             },
        //         {
        //             title: 'setTimeout 3 Cheap villa 3',
        //             content: 'setTimeout 3 Very villa 3'
        //             },
        //         {
        //             title: 'Cheap villa 4',
        //             content: 'Very cheap villa 4'
        //             },
        //         {
        //             title: 'setTimeout 5 Cheap villa 5',
        //             content: 'setTimeout 5 Very villa 5'
        //             },
        //         {
        //             title: 'Cheap villa 6',
        //             content: 'Very cheap villa 6'
        //             },
        //         {
        //             title: 'setTimeout 7 Cheap villa 7',
        //             content: 'setTimeout 7 Very villa 7'
        //             },
        //         {
        //             title: 'Cheap villa 8',
        //             content: 'Very cheap villa 8'
        //             },
        //         {
        //             title: 'setTimeout 9 Cheap villa 9',
        //             content: 'setTimeout 9 Very villa 9'
        //             },
        //         {
        //             title: 'Cheap villa 10',
        //             content: 'Very cheap villa 10'
        //             }
        //     ];
        // this.loading = false;
        // }, 2000);


        // const prom = new Promise((resolve, reject) => {
        //     console.log(resolve);
        //     console.log(reject);
        //     setTimeout(() => resolve("Hello"), 3000);
        // })
        // .then(result => 'Hello again ' + result)
        // .then(result => console.log(`Success ${result}`))
        // .catch(result => console.log(`Error ${result}`));
        // console.log(prom);
        axios.get('api/bookables')
        .then(res => 
            {this.bookables =  res.data;
            //  this.bookables.push();
             this.loading = false})
        .catch(error => console.log(error))
    }
};
</script>
