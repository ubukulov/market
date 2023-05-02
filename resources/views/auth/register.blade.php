@extends('layouts.auth')
@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="login-form">
                <div class="login_elements">
                    <h4>Регистрация</h4>

                    <div v-if="!register_success" id="carouselExampleIndicators" class="carousel slide" data-bs-touch="false" data-bs-interval="false">
                        <div class="carousel-indicators">
                            <button type="button" disabled data-bs-target="#carouselExampleIndicators" data-bs-slide-to="0" :class="{'active' : step===1}" aria-current="true" aria-label="Slide 1"></button>
                            <button type="button" disabled data-bs-target="#carouselExampleIndicators" data-bs-slide-to="1" :class="{'active' : step===2}" aria-label="Slide 2"></button>
                        </div>
                        <div class="carousel-inner">
                            <div class="carousel-item" :class="{'active' : step===1}">
                                <h6 style="text-align: center">Заполните личные данные</h6>
{{--                                <pre>@{{ v$ }}</pre>--}}
                                <div class="form-group mb-4">
                                    <input type="text" v-model="v$.full_name.$model" class="form-control" placeholder="ФИО">
                                    <span class="auth_error_text" v-if="v$.full_name.$invalid">
                                        Поле обязательно
                                    </span>
                                </div>

                                <div class="form-group mb-4">
                                    <input type="email" v-model="email" class="form-control" placeholder="E-mail">
                                    <span class="auth_error_text" v-if="v$.email.$invalid">
                                        Введите пожалуйста правильную почту
                                    </span>
                                </div>

                                <div class="form-group mb-4">
                                    <input id="phone-mask" type="text" v-model="phone" class="form-control" placeholder="Номер телефона">
                                    <span class="auth_error_text" v-if="v$.phone.$invalid">
                                        Введите правильный номер телефона
                                    </span>
                                </div>
                            </div>
                            <div class="carousel-item" :class="{'active' : step===2}">
                                <h6 style="text-align: center">Заполните данные для договора</h6>
                                <div class="form-group mb-4">
                                    <input id="bin" type="text" v-model="bin" class="form-control" placeholder="БИН">
                                    <span class="auth_error_text" v-if="v$.bin.$invalid">
                                        Поле обязательно
                                    </span>
                                </div>

                                <div class="form-group mb-4">
                                    <input type="text" v-model="legal_address" class="form-control" placeholder="Юридический адрес (полный)">
                                    <span class="auth_error_text" v-if="v$.legal_address.$invalid">
                                        Поле обязательно
                                    </span>
                                </div>

                                <div class="form-group mb-4">
                                    <input type="text" v-model="bik" class="form-control" placeholder="БИК">
                                    <span class="auth_error_text" v-if="v$.bik.$invalid">
                                        Поле обязательно
                                    </span>
                                </div>

                                <div class="form-group mb-4">
                                    <input type="text" v-model="bank" class="form-control" placeholder="Банк">
                                    <span class="auth_error_text" v-if="v$.bank.$invalid">
                                        Поле обязательно
                                    </span>
                                </div>

                                <div class="form-group mb-4">
                                    <input type="text" v-model="iik" class="form-control" placeholder="ИИК (номер счёта)">
                                    <span class="auth_error_text" v-if="v$.iik.$invalid">
                                        Поле обязательно
                                    </span>
                                </div>

                                <div class="form-group mb-4">
                                    <input type="text" v-model="full_name_director" class="form-control" placeholder="ФИО директора">
                                    <span class="auth_error_text" v-if="v$.full_name_director.$invalid">
                                        Поле обязательно
                                    </span>
                                </div>
                            </div>
                        </div>

                        <div class="form-group mb-2 mt-5">
                            <button v-if="step===1" @click="step=2" :disabled="isSuccess" type="button" class="btn btn-success auth_next_btn">Далее</button>

                            <button v-if="step===2" @click="register()" :disabled="v$.$invalid" type="button" class="btn btn-success auth_next_btn">Отправить заявку</button>
                        </div>

                        <div class="form-group mt-5">
                            <p><span>Есть аккаунт?</span>&nbsp;<a href="{{ route('loginForm') }}" class="auth_a_links">Войти</a></p>
                        </div>
                    </div>

                    <div v-if="register_success" class="register_success">
                        <h6>Заявка принята!</h6>

                        <p>Ожидайте подтверждения. На указанную почту будет отправлена ссылка. Перейдите по ней для завершения регистрации. </p>

                        <a href="{{ route('home') }}">На главную</a>
                    </div>

                </div>
            </div>
        </div>
    </div>
@stop
@push('scripts')
    <!--  Vuelidate -->
    <script src="https://cdn.jsdelivr.net/npm/vue-demi"></script>
    <script src="https://cdn.jsdelivr.net/npm/@vuelidate/core"></script>
    <script src="https://cdn.jsdelivr.net/npm/@vuelidate/validators"></script>
    <script src="https://unpkg.com/imask"></script>
    <script type="text/javascript">
        document.addEventListener("DOMContentLoaded", function () {
            IMask(document.getElementById('phone-mask'), {
                mask: '+{7} 000 000 0000'
            });
        });
    </script>
    <script>
        const { useVuelidate  } = window.Vuelidate;
        const { required, email, minLength } = window.VuelidateValidators;

        new Vue({
            el: '#wrap',
            data() {
                return {
                    full_name: '',
                    email: '',
                    phone: '',
                    bin: '',
                    legal_address: '',
                    bik: '',
                    bank: '',
                    iik: '',
                    full_name_director: '',
                    step: 1,
                    register_success: false
                }
            },
            setup: () => ({ v$: useVuelidate() }),
            validations() {
                return {
                    full_name: { required },
                    email: { email },
                    phone: {required, minLength: minLength(15)},
                    bin: { required },
                    legal_address: { required },
                    bik: { required },
                    bank: { required },
                    iik: { required },
                    full_name_director: { required },
                }
            },
            computed: {
                isSuccess() {
                    if(this.v$.full_name.$invalid) {
                        return true;
                    } else if(this.v$.email.$invalid) {
                        return true;
                    } else if(this.v$.phone.$invalid) {
                        return true;
                    } else {
                        return false;
                    }
                }
            },
            methods: {
                register(){
                    let formData = new FormData();
                    formData.append('full_name', this.full_name);
                    formData.append('email', this.email);
                    formData.append('phone', this.phone);
                    formData.append('bin', this.bin);
                    formData.append('legal_address', this.legal_address);
                    formData.append('bik', this.bik);
                    formData.append('bank', this.bank);
                    formData.append('iik', this.iik);
                    formData.append('full_name_director', this.full_name_director);

                    axios.post('/registration', formData)
                    .then(res => {
                        console.log(res);
                        this.register_success = true;
                    })
                    .catch(err => {
                        console.log(err);
                    })
                }
            }
        });
    </script>
@endpush
