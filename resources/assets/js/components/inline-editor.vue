<template>
    <center>
        <div v-if="!show">
             <span class="concat-title" :class="{'left-90': editable, 'max-width-100': !editable}">{{value}}</span>
              <i v-if="editable" class="si si-pencil si-left push-5-l cursor-pointer" @click="() => show = true"></i>
             <div class="clearfix"></div>
        </div>
        <div v-if="show && editable" class="form-group inline" :class="{'has-error': error}">
            <input type="text" class="form-control" @change="change($event)" @blur="change($event)"
                   :value="value"/>
        </div>
    </center>
</template>

<script>
    export default {
        props: ['value', 'editable'],
        data: function () {
            return {
                show: false,
                error: false,
            }
        },
        mounted: function () {

        },
        watch: {
            value: function (value) {
                $(this.$el).find('input[type="text"]').val(value);
            },
            show: function (value) {
                if(value) {
                    this.$nextTick(function () {
                        $(this.$el).find('input[type="text"]').focus();
                    });
                }
            }
        },
        methods: {
            change: function (event) {
                if(!event.target.value.length) {
                    this.error = true;
                    return;
                }
                if(this.value != event.target.value) {
                    this.$emit('input', event.target.value);
                }
                this.show = this.error = false;
            }
        }
    }
</script>
