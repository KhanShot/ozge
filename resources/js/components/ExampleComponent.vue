<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="mt-3">
                    <div class="text-center"><img src="logo.png" height="50"></div>
                    <div class="mt-4">
                        <div class="form-group">
                            <label>Промокод </label>
                            <input type="text" required class="form-control " v-model="form.promo">
                        </div>
                        <div class="form-group d-flex flex-row-reverse justify-content-end mt-2">
                            <label for="checkbox" style="margin-left: 10px"><a href="www.google.com" target="_blank">Келісім шартпен</a> таныстым</label>
                            <input type="checkbox" id="checkbox" v-model="form.is_agree" required class="form-check">
                        </div>
                    </div>
                    <div class="mt-3 w-100">
                        <button class="btn-danger btn w-100" @click="startSpin">Айналдыру</button>
                    </div>
                    <div class="d-flex justify-content-center mt-3 align-items-center">
                        <FortuneWheel
			    v-if="!isLoading"
                            style="max-width: 500px"
                            borderColor="#584b43"
                            :borderWidth="6"
                            :verify="canvasVerify"
                            :canvas="canvasOptions"
                            :prizes="prizes"
                            :disabled="canvasOptions.disabled"
                            @rotateStart="onCanvasRotateStart"
                            @rotateEnd="onRotateEnd"
                        />
                    </div>
                    <div class="d-flex justify-content-center align-items-center mt-2 footer">
                        © 2024 "Ozge" бренд коллекциясы
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import FortuneWheel from 'vue-fortune-wheel'
import 'vue-fortune-wheel/style.css'
import CryptoJS from "crypto-js";
    export default {
        components: {
          FortuneWheel,
        },
        data() {
          return {
              key: import.meta.env.VITE_API_KEY,
	      isLoading: true,
              form:{
                  promo: null,
                  is_agree: true
              },
              canvasVerify: false,
              canvasOptions: {
                  borderWidth: 6,
                  borderColor: '#bb708e',
                  textDirection: "vertical",
                  btnWidth: 80,
                  fontSize: 16,
                  textLength: 10,
                  btnText: '',
                  disabled: true,
              },
              prizes:[]
            }
        },
        mounted() {

            console.log('Component mounted.')
        },
        created() {
            this.getPrizes()
        },
        methods: {

            onCanvasRotateStart(rotate) {
                if (this.canvasVerify) {
                    const verified = true // true: the test passed the verification, false: the test failed the verification
                    this.DoServiceVerify(verified, 500).then((verifiedRes) => {
                        if (verifiedRes) {
                            console.log('Verification passed, start to rotate')
                            rotate()
                            this.canvasVerify = false
                            this.canvasOptions.disabled = true
                        } else {
                            alert('Failed verification')
                        }
                    })
                }else{
                    console.log('not allowed')
                }
                console.log('onCanvasRotateStart')
            },
            encryptP(value, apiKey) {
                return CryptoJS.AES.encrypt(value.toString(), apiKey, {}).toString();
            },
            startSpin(){
                if (this.form.promo === null || !this.form.is_agree){
                    this.$swal.fire({
                        icon: "error",
                        title: "Ошибка",
                        text: "Проверьте все поля!",
                    });
                }else{
                    axios
                        .post('/prizes/check', this.form)
                        .then((response) => {
                            this.canvasVerify = true
                            this.canvasOptions.disabled = false
                            setTimeout(function () {
                                document.getElementsByClassName('fw-btn__btn')[0].click()
                            }, 200)
                        }).catch((error) => {
                            this.$swal.fire({
                                icon: "error",
                                title: "Ошибка",
                                text: error.response.data.msg,
                            });
                        })
                }


            },
            onRotateEnd(prize) {
                let newData = {
                    id: prize.id,
                    promo: this.form.promo
                }
                let encData = this.$LaravelVueCrypto.encrypt(newData)

                axios
                    .post('/prizes/assign', encData)
                    .then((response) => {
                        this.$swal.fire({
                            icon:"success",
                            title: 'Ұтыс!',
                            text: prize.value,
                            backdrop: `
                                rgba(0,0,123,0.4)
                                url("https://i.pinimg.com/originals/fd/b0/9c/fdb09cd5e747f5c8330f998f11efb0a1.gif")
                                center
                                no-repeat`
                        })
                        console.log(response.data)
                    }).catch((error) => {
                    this.$swal.fire({
                        icon: "error",
                        title: "Ошибка",
                        text: error.response.data.msg,
                    });
                })

            },
            getPrizes(){
                axios
                    .get('/p-list')
                    .then((response) => {
                        let data = response.data;
                    	this.prizes = data;
			this.isLoading = false;
			}).catch((error) => {
      				this.isLoading = false; // Ensure the loading state is false even if there is an error
      				console.error('Error fetching prizes:', error);
      				// Handle the error gracefully (e.g., show a message to the user)
    			});;
            },
            // Simulate the request back-end interface, verified: whether to pass the verification, duration: delay time
            DoServiceVerify(verified, duration) {
                return new Promise((resove) => {
                    setTimeout(() => {
                        resove(verified)
                    }, duration)
                })
            }
        }
    }
</script>

