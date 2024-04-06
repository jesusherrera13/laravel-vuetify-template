<template>
    
    <div class="text-subtitle-1 text-medium-emphasis">Name</div>

    <v-text-field
        v-model="user.name"
      density="compact"
      placeholder="Name"
      prepend-inner-icon="mdi-account"
      variant="outlined"
    ></v-text-field>

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
    </div>

    <v-text-field
        v-model="user.password"
      :append-inner-icon="visible_1 ? 'mdi-eye-off' : 'mdi-eye'"
      :type="visible_1 ? 'text' : 'password'"
      density="compact"
      placeholder="Enter your password"
      prepend-inner-icon="mdi-lock-outline"
      variant="outlined"
      @click:append-inner="visible_1 = !visible_1"
    ></v-text-field>

    <v-text-field
        v-model="user.password_confirmation"
      :append-inner-icon="visible_2 ? 'mdi-eye-off' : 'mdi-eye'"
      :type="visible_2 ? 'text' : 'password'"
      density="compact"
      placeholder="Confirm your password"
      prepend-inner-icon="mdi-lock-outline"
      variant="outlined"
      @click:append-inner="visible_2 = !visible_2"
    ></v-text-field>

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
      @click="register"
    >
      Register
    </v-btn>

    <v-card-text class="text-center">
      <a
        class="text-blue text-decoration-none"
        href="/login"
        rel="noopener noreferrer"
      >
        Login <v-icon icon="mdi-chevron-right"></v-icon>
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
      visible_1: false,
      visible_2: false,
      progress: false,
      alert: false,
      error_message: null,
      user: {
          name: null,
          email: null,
          password: null,
          password_confirmation: null,
      }
  }),
  methods: {
      register() {
          this.progress = true;
          store.dispatch('register', this.user)
          .then(res => {
              this.progress = false;
              this.$router.push({ name: 'Dashboard'});
          })
          .catch(err => {
            console.log(err)
              this.progress = false;
              this.alert = true;
              this.error_message = err.response.data.message ? err.response.data.message : err.message;
              errorMsg.value = err.response.data.message;
          });
      }
  }
}

</script>