<template>
    <div :id="id" class="audioplayer-tobe" data-videoTitle="Audio Video" data-type="normal" :data-source="sound"
         data-playfrom="0">
        <div class="meta-artist">
            <span class="the-artist" v-if="artist" v-text="artist"></span>&nbsp;
            <span class="the-name" v-if="name" v-text="name"></span>
        </div>
    </div>
</template>

<script>

    export default {
        props: {
            id: {
                type: String,
                required: true
            },
            artist: {
                type: String,
                default: ''
            },
            name: {
                type: String,
                default: ''
            },
            sound: {
                type: String,
                required: true
            },
            disable_volume: {
                type: String,
                default: 'on'
            },
            cue: {
                type: String,
                default: 'on'
            },
            autoplay: {
                type: String,
                default: 'off'
            },
            disable_scrub: {
                type: String,
                default: 'default'
            },
            design_skin: {
                type: String,
                default: 'skin-wave'
            },
            skinwave_dynamicwaves: {
                type: String,
                default: 'on'
            },
            skinwave_enableSpectrum: {
                type: String,
                default: 'off'
            },
            settings_backup_type: {
                type: String,
                default: 'full'
            },
            skinwave_wave_mode: {
                type: String,
                default: 'canvas'
            },
            pcm_data_try_to_generate: {
                type: String,
                default: 'on'
            },
            design_color_bg: {
                type: String,
                default: '222222'
            },
            settings_php_handler: {
                type: String,
                default: ''
            },
            design_color_highlight: {
                type: String,
                default: '8dc63f'
            },
            settings_useflashplayer: {
                type: String,
                default: 'auto'
            },
            skinwave_spectrummultiplier: {
                type: Number,
                default: 4
            },
            skinwave_comments_retrievefromajax: {
                type: String,
                default: 'off'
            },
            skinwave_comments_enable: {
                type: String,
                default: 'off'
            },
            settings_extrahtml: {
                type: String,
                default: ''
            },
            playfrom: {
                type: Number,
                default: 0
            },
        },
        methods: {},
        mounted () {
            var self = this;
            setTimeout(function () {
                self.player = dzsap_init('#' + self.id + '', {
                    disable_volume: self.cue
                    , cue: self.cue
                    , autoplay: self.autoplay
                    , disable_scrub: self.disable_scrub
                    , design_skin: self.design_skin
                    , skinwave_dynamicwaves: self.skinwave_dynamicwaves
                    , skinwave_enableSpectrum: self.skinwave_enableSpectrum
                    , settings_backup_type: self.settings_backup_type
                    , skinwave_wave_mode: self.skinwave_wave_mode
                    , pcm_data_try_to_generate: self.pcm_data_try_to_generate
                    , settings_php_handler: self.settings_php_handler
                    , design_color_bg: self.design_color_bg
                    , design_color_highlight: self.design_color_highlight
                    , settings_useflashplayer: self.settings_useflashplayer
                    , skinwave_spectrummultiplier: self.skinwave_spectrummultiplier
                    , skinwave_comments_retrievefromajax: self.skinwave_comments_retrievefromajax
                    , skinwave_comments_playerid: self.id
                    , skinwave_comments_enable: self.skinwave_comments_enable
                    , settings_extrahtml: self.settings_extrahtml
                    , playfrom: self.playfrom
                });
            }, 500);
        },

        beforeDestroy () {
            this.player.destroy();
        }
    }

</script>