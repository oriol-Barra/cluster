<template>
    <div class="min-h-screen flex flex-col justify-center items-center bg-cover">
      <div class="bg-white p-8 rounded-lg shadow-lg w-full max-w-md">
        <h1 class="text-3xl font-bold mb-8 text-center">
          Iniciar Sessió
        </h1>
        <form @submit.prevent="submit">
          <div class="mb-4">
            <label class="block text-gray-700" for="email">Email</label>
            <input
              id="email"
              v-model="email"
              class="form-input mt-1 block w-full h-12 rounded px-4 border border-gray-300"
              type="email"
              required
              placeholder="Email"
            />
          </div>
          <div class="mb-4">
            <label class="block text-gray-700" for="password">Contrasenya</label>
            <input
              id="password"
              v-model="password"
              class="form-input mt-1 block w-full h-12 rounded px-4 border border-gray-300"
              type="password"
              required
              placeholder="Contrasenya"
            />
          </div>
          <button
            class="bg-blue-500 text-white py-2 px-4 rounded hover:bg-blue-700 w-full mb-4"
            type="submit"
          >
            Iniciar Sessió
          </button>
        </form>
        <div class="flex justify-center w-full">
          <router-link to="/recuperarPassword" class="text-blue-500 hover:underline">
            Recuperar contrasenya
          </router-link>
        </div>
      </div>
    </div>
  </template>
  
  <script>
  import axios from 'axios';
  
  export default {
    name: 'LoginPage',
    data() {
      return {
        email: '',
        password: '',
      };
    },
    methods: {
      async submit() {
        if (!this.email || !this.password) {
          alert('Si us plau, omple tots els camps.');
          return;
        }
        try {
          const baseURL = process.env.VUE_APP_API_BASE_URL || 'http://localhost:8088';
          const response = await axios.post(`${baseURL}/api/login`, {
            email: this.email,
            password: this.password, // Cambio para asegurarnos de que coincida con el backend
          });
          if (response.status === 200) {
            console.log(response.data);            
  
            // Guardar datos en LocalStorage
            localStorage.setItem('authToken', response.data.token);
            localStorage.setItem('nom_usuari', response.data.user.name);
            this.$emit('login', true); // Emitir un evento de login exitoso
            alert(`Benvingut/da: ${response.data.message}`);
            this.$router.push("/dashboard");

          }
        } catch (error) {
          const errorMessage = error.response?.data?.error || 'Error inesperat';
          alert(`Hi ha hagut un error: ${errorMessage}`);
        }
      },
    },
  };
  </script>
  
  <style scoped>
  </style>
  