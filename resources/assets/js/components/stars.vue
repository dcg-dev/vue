<template>
    <span class="text-warning">
        <i v-for="(value, index) in stars" :class="'fa '+value"></i>
    </span>
</template>
<script>
  export default {
    props: {
        rating: {
            type: Number,
            required: true
        }
    },
    computed: {
        stars: function() {
            var results = [];
            var rating = Math.ceil(this.rating);
            for(var i=1; i<=5; i++) {
                results.push(i>rating ? 'fa-star-o': 'fa-star');
            }
            return results;
        }
    }
}
</script>