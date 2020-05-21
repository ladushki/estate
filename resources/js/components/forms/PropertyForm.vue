
<script>
    import 'vue2-dropzone/dist/vue2Dropzone.min.css';
    import vue2Dropzone from '../Dropzone.vue';
    export default {
        mixins: [Laraform],
        components: {
            dropzone: vue2Dropzone
        },
        created() {
            this.on('response', (response) => {
                window.location = response.payload['redirect'];
            })
        },

    }
</script>
