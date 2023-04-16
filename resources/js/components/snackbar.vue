<template>
  <div class="text-center">
    <v-snackbar
      v-model="snackbar"
      :timeout="timeout"
    >
      {{ text }}

      <template v-slot:action="{ attrs }">
        <v-btn
          color="error"
          text
          v-bind="attrs"
          @click="snackbar = false"
        >
          Close
        </v-btn>
      </template>
    </v-snackbar>
  </div>
</template>
<script>
  export default {
     props: {
        color: {
        type: String,
        default: 'error',
        },
        timeout: {
        type: Number,
        default: 3000,
        },
        top: {
        type: Boolean,
        default: false,
        },
    },
    data: () => ({
      text: 'Wrong Credentials, Please Try Again',
    }),
  }
</script>