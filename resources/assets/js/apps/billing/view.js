if (document.getElementById('upgrade-subscriptions-view')) {
    window.viewSubscriptions = new Vue({
        el: '#upgrade-subscriptions-view', 
        data: {
            plan: new Plan(window.currentPlan),
        },
        mounted: function () {
//            if(window.currentPlan) {
//                this.plan = new Plan(window.currentPlan);
//            }
        },
        methods: {
            
        },
    });
}