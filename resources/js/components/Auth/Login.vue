<template>
    <navbar btnBackground="bg-gradient-success"/>
    <div
        class="page-header align-items-start min-vh-100"
        style="
      background-image: url('https://www.gamerroof.com/wp-content/uploads/2019/05/SCUM-Full-Version-Free-Download.jpg');
    "
    >
        <span class="mask bg-gradient-dark opacity-6"></span>
        <div class="container my-auto">
            <div class="row">
                <div class="col-lg-4 col-md-8 col-12 mx-auto">
                    <div class="card z-index-0 fadeIn3 fadeInBottom">
                        <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
                            <div
                                class="bg-gradient-dark shadow-success border-radius-lg py-3 pe-1"
                            >
                                <h4 class="text-white font-weight-bolder text-center mt-2 mb-0">
                                    Sign in
                                </h4>
                            </div>
                        </div>
                        <div class="card-body">
                            <form role="form" class="text-start mt-3" @submit.prevent="submit">
                                <div class="mb-3">
                                    <vmd-input type="text" label="Login ID" v-model="form.login_id"/>
                                </div>
                                <div class="mb-3">
                                    <vmd-input type="password" label="Password" v-model="form.password"/>
                                </div>
                                <vmd-switch id="rememberMe">Remember me</vmd-switch>
                                <div class="text-center">
                                    <vmd-button
                                        class="my-4 mb-2"
                                        variant="gradient"
                                        color="dark"
                                        type="submit"
                                        fullWidth
                                    >Sign in
                                    </vmd-button>
                                </div>
                                <p class="mt-4 text-sm text-center">
                                    Don't have an account?
                                    <router-link
                                        :to="{ name: 'SignUp' }"
                                        class="text-dark text-gradient font-weight-bold"
                                    >Sign up
                                    </router-link
                                    >
                                </p>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <footer class="footer position-absolute bottom-2 py-2 w-100">
            <div class="container">
                <div class="row align-items-center justify-content-lg-between">
                    <div class="col-12 col-md-6 my-auto">
                        <div class="copyright text-center text-sm text-white text-lg-start">
                            © {{ new Date().getFullYear() }}, made with by ragiarks
                        </div>
                    </div>
                    <div class="col-12 col-md-6">
                        <ul
                            class="nav nav-footer justify-content-center justify-content-lg-end"
                        >
                            <li class="nav-item">
                                <a
                                    href="https://www.creative-tim.com"
                                    class="nav-link text-white"
                                    target="_blank"
                                >Discord Community</a
                                >
                            </li>
                            <li class="nav-item">
                                <a
                                    href="https://www.creative-tim.com/presentation"
                                    class="nav-link text-white"
                                    target="_blank"
                                >Contact</a
                                >
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </footer>
    </div>
</template>

<script>
import Navbar from "../../../vue-material-dashboard-2/src/examples/PageLayout/Navbar.vue";
import VmdInput from "../../../vue-material-dashboard-2/src/components/VmdInput.vue";
import VmdSwitch from "../../../vue-material-dashboard-2/src/components/VmdSwitch.vue";
import VmdButton from "../../../vue-material-dashboard-2/src/components/VmdButton.vue";
import {mapActions} from "vuex";

export default {
    name: "sign-in",
    components: {
        Navbar,
        VmdInput,
        VmdSwitch,
        VmdButton,
    },
    data() {
        return {
            form: {
                login_id: '',
                password: '',
            },
        };
    },
    beforeMount() {
        this.$store.state.hideConfigButton = true;
        this.$store.state.showNavbar = false;
        this.$store.state.showSidenav = false;
        this.$store.state.showFooter = false;
    },
    beforeUnmount() {
        this.$store.state.hideConfigButton = false;
        this.$store.state.showNavbar = true;
        this.$store.state.showSidenav = true;
        this.$store.state.showFooter = true;
    },
};
</script>
