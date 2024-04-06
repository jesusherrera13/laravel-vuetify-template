<template>
    
    <div class="text-subtitle-1 text-medium-emphasis">Account</div>

    <v-text-field
        v-model="user.email"
      density="compact"
      placeholder="Email address"
      prepend-inner-icon="mdi-email-outline"
      variant="outlined"
    ></v-text-field>

    <div class="text-subtitle-1 text-medium-emphasis d-flex align-center justify-space-between">
      Password

      <a
        class="text-caption text-decoration-none text-blue"
        href="#"
        rel="noopener noreferrer"
        target="_blank"
      >
        Forgot login password?</a>
    </div>

    <v-text-field
        v-model="user.password"
      :append-inner-icon="visible ? 'mdi-eye-off' : 'mdi-eye'"
      :type="visible ? 'text' : 'password'"
      density="compact"
      placeholder="Enter your password"
      prepend-inner-icon="mdi-lock-outline"
      variant="outlined"
      @click:append-inner="visible = !visible"
    ></v-text-field>

    <!-- <v-card
      class="mb-12"
      color="surface-variant"
      variant="tonal"
    >
      <v-card-text class="text-medium-emphasis text-caption">
        Warning: After 3 consecutive failed login attempts, you account will be temporarily locked for three hours. If you must login now, you can also click "Forgot login password?" below to reset the login password.
      </v-card-text>
    </v-card> -->

    <v-alert
      v-model="alert"
      border="start"
      variant="tonal"
      closable
      close-label="Close Alert"
      type="warning"
      title="Error"
      class="mb-12"
    >
      <v-card-text class="text-medium-emphasis text-caption">
        {{ error_message }}  
      </v-card-text>
    </v-alert>

    <ProgressLinear v-if="progress" />
    <v-btn
      block
      class="mb-8"
      color="blue"
      size="large"
      variant="tonal"
      @click="login"
    >
      Log In
    </v-btn>

    <v-card-text class="text-center">
      <a
        class="text-blue text-decoration-none"
        href="/register"
        rel="noopener noreferrer"
      >
        Sign up now <v-icon icon="mdi-chevron-right"></v-icon>
      </a>
    </v-card-text>
  
</template>
<script>

import { ref } from 'vue';
import store from '../../../store';
import ProgressLinear from '../../ProgressLinear.vue';
// const router = useRouter();

let errorMsg = ref('')

export default {
    data: () => ({
        visible: false,
        progress: false,
        alert: false,
        error_message: null,
        user: {
            email: 'eljuegoperfectomx13@gmail.com',
            password: 'herrera',
        }
    }),
    components: {
        ProgressLinear
    },
    methods: {
        login() {
            this.progress = true;
            store.dispatch('login', this.user)
            .then(res => {
                this.progress = false;
                this.$router.push({ name: 'Dashboard'});
            })
            .catch(err => {
                this.progress = false;
                this.alert = true;
                this.error_message = err.response.data.message ? err.response.data.message : err.message;
                errorMsg.value = err.response.data.message;
            });
        }
    }
}

</script>