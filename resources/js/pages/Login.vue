<template>
  <v-app>
    <div>
      <v-sheet style="max-height: 101.2vh;" fluid>
        <div class="text-center login">
          <v-card width="500" class="mx-auto" elevation="3" color="white">
            <v-card>
              <div style="padding-top: 4%">
                <v-img contain :src="logocard" max-height="30%" width="50%" class="mx-auto" />
              </div>

              <v-col>
                <v-text-field v-model="email" dense filled label="Email"></v-text-field>

                <v-text-field
                  v-model="password"
                  dense
                  filled
                  :type="isPasswordVisible ? 'text' : 'password'"
                  label="Password"
                  placeholder="············"
                  :append-icon="isPasswordVisible ? icons.mdiEyeOffOutline : icons.mdiEyeOutline"
                  @click:append="isPasswordVisible = !isPasswordVisible"
                ></v-text-field>

                <v-card-actions>
                  <v-spacer></v-spacer>
                  <v-btn color="primary" class="mb-2 px-7" @click="Login()">Login</v-btn>
                  <v-spacer></v-spacer>
                </v-card-actions>
                <fail-snack-bar v-model="show" />
              </v-col>
            </v-card>
          </v-card>
        </div>
      </v-sheet>
    </div>
  </v-app>
</template>

<script>
import logo from "../assets/logo.jpg";
import logocard from "../assets/logo.jpg";
import { mdiEyeOutline, mdiEyeOffOutline } from "@mdi/js";
import { login } from "../repositories/user.api";
import FailSnackBar from "../components/snackbar.vue";

export default {
  components: {
    FailSnackBar,
  },
  data() {
    return {
      isPasswordVisible: false,
      icons: {
        mdiEyeOutline,
        mdiEyeOffOutline,
      },
      logo,
      logocard,
      email: "",
      password: "",
    };
  },
  methods: {
    Login() {
      const login_data = {
        email: this.email,
        password: this.password,
      };
      login(login_data)
        .then(({ data }) => {
          //   this.$store.commit('login', data)
          localStorage.setItem("token", data.access_token);
          this.routeEnter();
        })
        .catch((errors) => {
          console.log(errors);
          // Call the showSnackBar method when there is an error
            window.alert("Wrong Credentials")
            this.email = ""
            this.password = ""
});
    },
    routeEnter() {
      this.$router.push("/");
    },
    routeAttend() {
      this.$router.push("/attendance");
    },
   
  },
};
</script>
<style>
/* .login-page {
padding-top : 10em;
background-color: green;
} */
body {
  overflow: hidden; /* Hide scrollbars */
}

.login {
    padding-top: 10%;
}



.border {
    background-color: white;
    border-top-left-radius: 100% 55%;
    border-bottom-left-radius: 100% 55%;
    height: 100%;
    border-style: solid;
    border-width: 5px;
    box-shadow: 2px 2px 4px #000000;
    padding-left: 2em;
    padding-right: 2em;
}

</style>