<template>
    <div class="block" v-if="form.show_skills">
        <div v-bind:class="'text-center block-content ' + ('undefined' !== typeof form.skills && form.skills.length > 0 ? 'block-content-full' : '')" >
            <h4 class="font-w300 push-20 text-left text-muted"><i class="fa fa-diamond text-muted"></i> My Skills</h4>
            <ul class="list list-simple text-left" style="column-count:2;" v-if="'undefined' !== typeof form.skills && form.skills.length > 0">
                <li v-for="skill in form.skills" v-if="skill.enabled"><i class="fa fa-check text-success"></i> <span v-text="skill.name"></span></li>
            </ul>
            <div class="push" v-else>
                <small>User doesn't have any skill</small>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        data() {
            return {}
        },
        props: {
            form: {
                required: true
            }
        },
        mounted: function () {
        },
        methods: {
        }
    }
</script>