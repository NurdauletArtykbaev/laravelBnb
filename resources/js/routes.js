 import VueRouter from 'vue-router'
 import Bookables from './bookabels/Bookables'
 import Bookable from './bookable/Bookable'
 import Review from './Review/Review'
import Basket from './Basket/Basket'
 const routes = [
     {
         path: '/',
         component:  Bookables,
         name: 'home'
     },
     {
        path: '/bookable/:id',
        component:  Bookable,
        name: 'bookable'
    },
    {
        path: '/review/:id',
        component: Review,
        name: 'review'
    },
    {
        path: '/basket',
        component: Basket,
        name: 'basket'
    },
    {
        path: '/auth/login',
        component: require('./auth/login.vue').default, //Альтернативакомпонента
        name: 'login'
    },
    {
        path: '/register',
        component: require('./auth/register.vue').default, //Альтернативакомпонента
        name: 'register'
    }
 ];

 const router = new VueRouter({
     routes,
     mode: 'history',
 });

 export default router;
