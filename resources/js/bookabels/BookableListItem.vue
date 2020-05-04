<template>
    <div class="card w-100">
        <!-- <h1>Title</h1>
        <p>Content</p> -->

        <!-- <h1>{{ title }}</h1>
        <p>{{ content }}</p> -->
        <div class="card-body">
            <router-link :to="{ name: 'bookable', params:{ id:id }}">
            <h5 class="card-title">{{ title }}</h5>
            </router-link>
            <p class="card-text">{{ description }}</p>
            <!-- <p class="card-text">{{ itemPrice }}</p> -->
        </div>
    </div>
</template>
<script>
export default {
    // props: ['title', 'content']
    // props: ['itemTitle', 'itemContent']
    // props: { itemTitle: String, itemDescription: String, itemPrice: Number }
    props: { id: Number, title: String, description: String }

};
</script>
