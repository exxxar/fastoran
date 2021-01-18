<template>
    <div>
        <h6 class="text-center">Запиши голосовое сообщение<br><strong class="text-danger">Удерживай кнопку для записи!</strong></h6>
        <div class="d-flex justify-content-center mt-2">
            <vue-record-audio :mode="'hold'" @stream="onStream" @result="onResult"/>
        </div>

        <div class="row d-flex justify-content-center mt-2" v-if="recordings.length>0">
            <div class="col-12">
                <div class="recorded-audio">
                    <div v-for="(record, index) in recordings" :key="index" class="recorded-item">
                        <div class="audio-container">
                            <audio :src="record.src" controls/>
                        </div>
                        <div>
                            <a @click="removeRecord(index)" class="button is-dark"><i class="fas fa-trash"></i></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>


</template>

<script>
    export default {
        name: 'app',
        props: ["phone","name","cansend"],
        data() {
            return {
                recommendations:false,
                recordings: []
            }
        },
        watch:{
            cansend:function (newVal) {
                if (newVal)
                    this.send();
            }
        },
        methods: {
            send() {

                let formData = new FormData();

                formData.append("phone", this.phone)
                formData.append("name", this.name)

                for (var i = 0; i < this.recordings.length; i++) {
                    let file = this.recordings[i].data;
                    console.log(file);
                    formData.append('files[' + i + ']', file);
                }

                axios.post('../api/v2/obedy/voice', formData, {
                        headers: {
                            'Content-Type': 'multipart/form-data'
                        },
                    }
                ).then(function () {
                    this.sendMessage("Голосовое сообщение успешно отправлено!")
                    this.recordings = []
                })
                    .catch(function () {
                    });
                this.recordings = []
            },
            removeRecord(index) {
                this.recordings.splice(index, 1)
            },
            onStream(stream) {
                console.log('Got a stream object:', stream);
            },
            onVideoStream(stream) {
                console.log('Got a video stream object:', stream);
            },
            onVideoResult(data) {
                this.$refs.Video.srcObject = null
                this.$refs.Video.src = window.URL.createObjectURL(data)
            },
            onResult(data) {
                this.recordings.push({
                    src: window.URL.createObjectURL(data),
                    data: data
                })
            },
            sendMessage(message) {
                this.$notify({
                    group: 'info',
                    type: 'success',
                    title: 'Отправка сообщений ОбедыGo',
                    text: message
                });
            },
        }
    }
</script>

<style lang="scss">


    .vue-audio-recorder, .vue-video-recorder {
        margin-right: 0px;
    }

    .record-settings {
        margin-top: 16px;
        display: flex;
        justify-content: flex-end;
    }

    .recorded-audio {
        margin: 0 auto;
        height: 200px;
        overflow: auto;
        border: thin solid #eee;
        background-color: #fffcfc;
        padding: 10px 5px;
        border-radius: 5px;
        box-shadow: 1px 1px 1px 0px inset;

        .recorded-item {
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 16px;
            padding: 0px 22px;
        }

        .audio-container {
            display: flex;
            height: 54px;
            margin-right: 16px;

            width: 100%;
            padding: 0px;
            box-sizing: border-box;
            align-items: center;
        }
    }

    .recorded-video {
        video {
            width: 100%;
            max-height: 400px;
        }
    }



</style>
