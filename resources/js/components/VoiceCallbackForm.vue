<template>
    <div>
        <h3 class="text-center">Запиши голосовое сообщение</h3>
        <div class="d-flex justify-content-center mt-2">
            <vue-record-audio :mode="'hold'" @stream="onStream" @result="onResult"/>
        </div>
        <div class="row d-flex justify-content-center mt-2">
            <div class="col-12">
                <div class="recorded-audio">
                    <div v-for="(record, index) in recordings" :key="index" class="recorded-item">
                        <div class="audio-container">
                            <audio :src="record.src" controls/>
                        </div>
                        <div>
                            <button @click="removeRecord(index)" class="button is-dark">delete</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row d-flex justify-content-center mt-2">
            <div class="col-12 col-sm-12 col-md-12">
               <button @click="send" class="w-100 food__btn ">Отправить голосовое сообщение</button>
            </div>
        </div>

    </div>


</template>

<script>
    export default {
        name: 'app',
        props:["phone"],
        data() {
            return {
                recordings: []
            }
        },
        methods: {
            send() {


                let formData = new FormData();

                formData.append("phone", this.phone)

                for (var i = 0; i < this.recordings.length; i++) {
                    let file = this.recordings[i].data;
                    console.log(file);
                    formData.append('files[' + i + ']', file);
                }

                axios.post('/fileupload', formData, {
                        headers: {
                            'Content-Type': 'multipart/form-data'
                        },
                    }
                ).then(function () {
                    this.recordings = []
                })
                    .catch(function () {
                    });

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
            }
        }
    }
</script>

<style lang="scss">



    .vue-audio-recorder, .vue-video-recorder {
        margin-right: 16px;
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
        background-color: #e0e0e0;
        padding: 10px 5px;
        box-shadow: 1px 1px 1px 1px inset;

        .recorded-item {
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 16px;
        }

        .audio-container {
            display: flex;
            height: 54px;
            margin-right: 16px;
        }
    }

    .recorded-video {
        video {
            width: 100%;
            max-height: 400px;
        }
    }


</style>
