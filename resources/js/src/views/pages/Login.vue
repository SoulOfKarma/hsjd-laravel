<!-- =========================================================================================
    File Name: Login.vue
    Description: Login Page
    ----------------------------------------------------------------------------------------
    Item Name: Vuexy - Vuejs, HTML & Laravel Admin Dashboard Template
      Author: Pixinvent
    Author URL: http://www.themeforest.net/user/pixinvent
========================================================================================== -->

<template>
    <div
        class="h-screen flex w-full bg-img vx-row no-gutter items-center justify-center"
        id="page-login"
    >
        <div class="vx-col sm:w-1/2 md:w-1/2 lg:w-3/4 xl:w-3/5 sm:m-0 m-4">
            <vx-card>
                <div slot="no-body" class="full-page-bg-color">
                    <div class="vx-row no-gutter justify-center items-center">
                        <div class="vx-col hidden lg:block lg:w-1/2">
                            <img
                                src="@assets/images/pages/login.png"
                                alt="login"
                                class="mx-auto"
                            />
                        </div>

                        <div
                            class="vx-col sm:w-full md:w-full lg:w-1/2 d-theme-dark-bg"
                        >
                            <div class="p-8 login-tabs-container">
                                <div class="vx-card__title mb-4">
                                    <h4 class="mb-4">Login</h4>
                                    <p>Bienvenido Al ???</p>
                                </div>

                                <div>
                                    <vs-input
                                        name="run"
                                        icon="icon icon-user"
                                        icon-pack="feather"
                                        label-placeholder="Run"
                                        v-model="run"
                                        v-on:blur="formatear_run"
                                        class="w-full no-icon-border"
                                    />
                                    <span
                                        style="font-size: 10px; color: red; margin-left: 10px;"
                                        v-if="val_run"
                                        >Run incorrecto</span
                                    >

                                    <vs-input
                                        type="password"
                                        name="password"
                                        icon="icon icon-lock"
                                        icon-pack="feather"
                                        label-placeholder="Password"
                                        v-model="password"
                                        class="w-full mt-6 no-icon-border"
                                    />
                                    <br />
                                    <input
                                        type="hidden"
                                        name="_token"
                                        :value="csrf_token"
                                    />
                                    <!-- <router-link to="../Home"> -->
                                    <vs-button
                                        class="float-right"
                                        @click="validarSesion"
                                        >Login</vs-button
                                    >
                                    <!-- </router-link> -->
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </vx-card>
        </div>
    </div>
</template>

<script>
import axios from "axios";
import router from "../../router";
import { validate, clean, format } from "rut.js";

export default {
    data() {
        return {
            run: "",
            password: "",
            val_run: false,
            checkbox_remember_me: false,
            localVal: "http://127.0.0.1:8000"
        };
    },
    computed: {
        csrf_token() {
            let token = document.head.querySelector('meta[name="csrf-token"]');
            return token.content;
        }
    },
    methods: {
        formatear_run() {
            this.run = format(this.run);
            this.val_run = !validate(this.run);
        },
        async validarSesion() {
            this.run = format(this.run);
            if (validate(this.run)) {
                var sw = 0;
                var pr = 0;
                var permiso_usuario = "";

                await axios
                    .post(this.localVal + "/api/Login/GetUsers", {
                        rut: this.run,
                        pasword: this.password
                    })
                    .then(function(response) {
                        if (response.data.length > 0) {
                            localStorage.setItem(
                                "nombre",
                                response.data[0].nombre
                            );
                            localStorage.setItem("run", response.data[0].run);
                            localStorage.setItem("id", response.data[0].id);
                            sw = 1;
                        } else {
                            pr = 1;
                        }
                    })
                    .catch(error => console.log(error));
                if (sw == 1) {
                    await axios
                        .post(this.localVal + "/api/Login/getpr", {
                            rut: this.run,
                            pasword: this.password
                        })
                        .then(function(response2) {
                            if (response2.data.length > 0) {
                                if (response2.data[0].estado_login == 1) {
                                    localStorage.setItem(
                                        "permiso_usuario",
                                        response2.data[0].permiso_usuario
                                    );
                                    if (
                                        response2.data[0].permiso_usuario == 1
                                    ) {
                                        pr = 3;
                                    }
                                    if (
                                        response2.data[0].permiso_usuario == 2
                                    ) {
                                        pr = 4;
                                    }
                                    //router.push('/home');
                                    //pr = 3;
                                } else {
                                    pr = 2;
                                }
                            }
                        });
                }
                if (pr == 1) {
                    this.$vs.notify({
                        color: "danger",
                        title: "Login",
                        text: "Usuario y/o Contraseña Incorrectos."
                    });
                }
                if (pr == 2) {
                    this.$vs.notify({
                        color: "danger",
                        title: "Login",
                        text: "Usted no posee acceso a la plataforma."
                    });
                }
                if (pr == 3) {
                    //localStorage.setItem('run',response2.data[0].permiso_usuario);
                    router.push("/agenteView/HomeAgente");
                }
                if (pr == 4) {
                    //localStorage.setItem('run',response2.data[0].permiso_usuario);
                    router.push("/home");
                } else {
                    this.val_run = true;
                }
            }
        }
    }
};
</script>

<style lang="scss">
#page-login {
    .social-login {
        .bg-facebook {
            background-color: #1551b1;
        }
        .bg-twitter {
            background-color: #00aaff;
        }
        .bg-google {
            background-color: #4285f4;
        }
        .bg-github {
            background-color: #333;
        }
    }
}
</style>
