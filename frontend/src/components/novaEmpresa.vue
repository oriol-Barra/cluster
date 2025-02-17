<!-- eslint-disable vue/multi-word-component-names -->
<template>
    <div class="min-h-screen flex flex-col justify-center items-center bg-cover">
      <div class="bg-white p-8 rounded-lg shadow-lg w-full max-w-md">
        <h1 class="text-3xl font-bold mb-8 text-center">
          Introdueix Empresa
        </h1>
        <form id="formulariregistre" @submit.prevent="submit">
          <div class="mb-4">
            <label class="block text-gray-700" for="ciff">CIFF</label>
            <input
              id="ciff"
              v-model="CIFF"
              class="form-input mt-1 block w-full h-12 rounded px-4 border border-gray-300"
              type="ciff"
              required
              placeholder="CIFF"
            >
          </div>

          <div class="mb-4">
            <label class="block text-gray-700" for="nom">Nom</label>
            <input
              id="nom"
              v-model="nom"
              class="form-input mt-1 block w-full h-12 rounded px-4 border border-gray-300"
              type="text"
              required
              placeholder="Nom"
            >
          </div>
  
          <div class="mb-4">
            <label class="block text-gray-700" for="direccio">Direcció</label>
            <input
              id="direccio"
              v-model="direcció"
              class="form-input mt-1 block w-full h-12 rounded px-4 border border-gray-300"
              type="text"
              required
              placeholder="Direcció"
            >
          </div>     
          <div class="mb-4">
          <label class="block text-gray-700" for="descripcio">Descripció de l'empresa</label>
          <TiptapEditor id="descripcio" v-model="descripcio" />
          </div>
      
  
          <button
            class="bg-blue-500 text-white py-2 px-4 rounded hover:bg-blue-700 w-full mb-4"
            type="submit"
          >
            Registre d'empresa
          </button>
        </form>
      </div>
    </div>
  </template>
  
  <script>
  import TiptapEditor from './tiptapeditor.vue';
  import axios from 'axios';
  
  export default {
    data() {
      return {
        nom: '',
        CIFF: '',
        direcció: '',
        descripcio: '',
      };
    },
    components: {
      TiptapEditor,
    },
    methods: {
      async submit() {
        try {
          const token = localStorage.getItem('authToken'); // Obtener el token de localStorage
          const baseURL = process.env.VUE_APP_API_BASE_URL || 'http://localhost:8088';
  
          // Realizar la solicitud POST
          const response = await axios.post(
            `${baseURL}/api/novaEmpresa`,
            {
              nom: this.nom,
              CIFF: this.CIFF,
              direcció: this.direcció,
              descripcio: this.descripcio,
            },
            {
              headers: {
                Authorization: `Bearer ${token}`, // Encabezados separados
              },
            }
          );
  
          // Verificar respuesta
          if (response.status === 201) {
            alert('Empresa registrada amb èxit!');
            document.getElementById('formulariregistre').reset();
          }
        } catch (error) {
          console.error(error.response?.data); // Detalles del error en consola
          alert(`Error de registre: ${error.response?.data.error || error.message}`);
        }
      },
    },
  };
  </script>
  
  
  <style scoped>
  </style>