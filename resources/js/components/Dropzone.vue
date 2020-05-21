<template>
    <vue-dropzone ref="myVueDropzone" id="dropzone"
                  :options="dropzoneOptions"
                  v-on:vdropzone-sending="sendingEvent"
    ></vue-dropzone>
</template>
<script>
    import vue2Dropzone from 'vue2-dropzone';
    import 'vue2-dropzone/dist/vue2Dropzone.min.css';

    export default {
        name: 'app',
        components: {
            vueDropzone: vue2Dropzone
        },
        data: function () {
            return {
                dropzoneOptions: {
                    url: '/admin/upload',
                    thumbnailWidth: 150,
                    maxFilesize: 0.5,
                    headers: {
                        "X-CSRF-TOKEN": document.head.querySelector("[name=csrf-token]").content
                    }
                }
            };
        },
        methods: {
            sendingEvent (file, xhr, formData) {
                formData.append('id', document.getElementById('uuid').value);
            }
        }
    };
</script>
