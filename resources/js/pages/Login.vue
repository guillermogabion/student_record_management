<template>
  <v-app>
    <div>
      <v-sheet style="max-height: 101.2vh;" fluid>
        <div class="text-center login">
          <v-card width="500" class="mx-auto" elevation="3" color="white">
            <v-card>
              <div style="padding-top: 4%">
                <v-img contain :src="logocard" max-height="30%" width="50%" class="mx-auto" style="border-radius : 50%" />
              </div>

              <v-col>
                <v-text-field v-model="email" dense filled label="Username/Email"></v-text-field>

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
                  <v-btn color="green" class="mb-2 px-7" @click="dialog = true">Register</v-btn>
                  <v-spacer></v-spacer>
                </v-card-actions>
                <fail-snack-bar v-model="show" />
              </v-col>
            </v-card>
          </v-card>
        </div>
      </v-sheet>
      <v-dialog
      v-model="dialog"
      width="500"
      >
        <v-card>
          <v-col>
                <v-text-field v-model="payload.first_name" dense filled label="First Name"></v-text-field>
                <v-text-field v-model="payload.last_name" dense filled label="Last Name"></v-text-field>
                <v-text-field v-model="payload.email" dense filled label="Username/Email"></v-text-field>
                <v-text-field
                  v-model="payload.password"
                  dense
                  filled
                  :type="isPasswordVisible ? 'text' : 'password'"
                  label="Password"
                  placeholder="············"
                  :append-icon="isPasswordVisible ? icons.mdiEyeOffOutline : icons.mdiEyeOutline"
                  @click:append="isPasswordVisible = !isPasswordVisible"
                ></v-text-field>
          </v-col>
          <v-card-actions>
            <v-spacer></v-spacer>
                  <v-btn color="green" class="mb-2 px-7" @click="createAdmin()">Register as User Admin</v-btn>
            <v-spacer></v-spacer>
          </v-card-actions>
        </v-card>
      </v-dialog>
    </div>
  </v-app>
</template>

<script>
import logo from "../assets/logo.jpg";
import logocard from "../assets/logos.jpg";
import { mdiEyeOutline, mdiEyeOffOutline } from "@mdi/js";
import { login } from "../repositories/user.api";
import FailSnackBar from "../components/snackbar.vue";
import axios from "../plugins/axios"

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
      payload : {
        first_name : "",
        last_name : "",
        email : "",
        password : ""
      },
      logo,
      logocard,
      email: "",
      password: "",
      dialog: false
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

    createAdmin(){
      axios.post('createAdmin', this.payload).then(res => {
         console.log(res)
          window.alert('Admin User Added');
          this.dialog = false
      })
    }
   
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