<!-- eslint-disable vue/multi-word-component-names -->
<template>
    <div class="min-h-screen flex flex-col justify-center items-center bg-cover">
      <div class="bg-white p-8 rounded-lg shadow-lg w-full max-w-md">
        <h1 class="text-3xl font-bold mb-8 text-center">
          Introdueix producte
        </h1>
        <form id="formulariregistre" @submit.prevent="submit">
          <div class="mb-4">
            <label class="block text-gray-700" for="nom">Nom</label>
            <input
              id="nom"
              v-model="nom"
              class="form-input mt-1 block w-full h-12 rounded px-4 border border-gray-300"
              type="ciff"
              required
              placeholder="Nom del producte"
            >
          </div>

          <div class="mb-4">
            <label class="block text-gray-700" for="nom">preu</label>
            <input
              id="preu"
              v-model="preu"
              class="form-input mt-1 block w-full h-12 rounded px-4 border border-gray-300"
              type="number"
              required
              placeholder="preu"
            >
          </div>
  
          <div class="mb-4">
            <label class="block text-gray-700" for="direccio">tipus impositiu</label>
            <input
              id="tipusImp"
              v-model="tipusImp"
              class="form-input mt-1 block w-full h-12 rounded px-4 border border-gray-300"
              type="number"
              step="0.01"
              required
              placeholder="tipus impositiu"
            >
          </div> 

          <div>
            <label class="block text-gray-700" for="idEmpresa">Empresa</label>
                <select
                    v-model="empresa"
                    class="form-select mt-1 block w-full h-12 rounded px-4 border border-gray-300"
                    required
                    >
                    <option value="" disabled>Selecciona una empresa</option>
                    <option v-for="empresa in empreses" :key="empresa.nom" :value="empresa.nom">
                    {{ empresa.nom }}
                    </option>
                </select>
          </div>    
          <div>
            <label class="block text-gray-700" for="idEmpresa">tipus de producte</label>
                <select
                    v-model="tipus"
                    class="form-select mt-1 block w-full h-12 rounded px-4 border border-gray-300"
                    required
                    >
                    <option value="" disabled>tipus de producte</option>
                    <option value="cervesa">cervesa</option>
                    <option value="kombutxa">kombutxa</option>
                </select>
          </div> 
          <div class="mb-4">
            <label class="block text-gray-700" for="foto">Foto del Producte</label>
            <input
              id="foto"
              type="file"
              @change="handleFileUpload"
              class="form-input mt-1 block w-full h-12 rounded px-4 border border-gray-300"
              accept="image/*"
            >
          </div>
          <div class="mb-4">
          <label class="block text-gray-700" for="descripcio">Descripció del producte</label>
          <TiptapEditor id="descripcio" v-model="descripcio" />
          </div>

  
          <button
            class="bg-blue-500 text-white py-2 px-4 rounded hover:bg-blue-700 w-full mb-4"
            type="submit"
          >
            Registre de producte
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
        preu: '',
        tipusImp: '',
        descripcio: '',
        tipus:'',
        empresa: '',
        empreses: [], // Lista de empresas cargadas
        foto:null,
      };
    },
    components: {
      TiptapEditor,
    },
    methods: {
      handleFileUpload(event) {
        this.foto = event.target.files[0];
      },
      async submit() {
        try {
          const token = localStorage.getItem('authToken'); // Obtener el token de localStorage
          const baseURL = process.env.VUE_APP_API_BASE_URL || 'http://localhost:8088';
          const formData = new FormData();
          formData.append('nom', this.nom);
          formData.append('preu', this.preu);
          formData.append('tipus_impositiu', this.tipusImp);
          formData.append('descripcio', this.descripcio);
          formData.append('empresa', this.empresa);
          formData.append('tipus', this.tipus);
          if (this.foto) {
            formData.append('foto', this.foto);
          }
  
  
          // Realizar la solicitud POST
          const response = await axios.post(
            `${baseURL}/api/nouProducte`,
            formData,
            {
              headers: {
                Authorization: `Bearer ${token}`, // Encabezados separados
                'Content-Type': 'multipart/form-data', // Necesario para enviar archivos
              },
            }
          );
  
          // Verificar respuesta
          if (response.status === 201) {
            alert('Producte registrat amb èxit!');
            document.getElementById('formulariregistre').reset();
            this.idEmpresa = ''; // Resetear el valor del select

          }
        } catch (error) {
          console.error(error.response?.data); // Detalles del error en consola
          alert(`Error de registre: ${error.response?.data.error || error.message}`);
        }
      },
      //funció per a carregar les empreses al desplegable
      async loadEmpreses() {
      try {
        const token = localStorage.getItem('authToken'); // Obtener el token
        const baseURL = process.env.VUE_APP_API_BASE_URL || 'http://localhost:8088';

        // Solicitar las empresas del usuario autenticado
        const response = await axios.get(`${baseURL}/api/empresesPerUser`, {
          headers: {
            Authorization: `Bearer ${token}`,
          },
        });
        this.empreses = response.data.empreses; // Cargar empresas en el estado
      } catch (error) {
        console.error('Error al cargar las empresas:', error.response?.data || error.message);
        alert('Error al cargar las empresas');
      }
    },
    },
    mounted() {
    this.loadEmpreses(); // Cargar empresas al montar el componente
  },
  };
  </script>
  
  
  <style scoped>
  </style>