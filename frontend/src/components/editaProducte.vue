<template>
    <div class="min-h-screen flex flex-col justify-center items-center bg-cover">
      <div class="bg-white p-8 rounded-lg shadow-lg w-full max-w-md">
        <h1 class="text-3xl font-bold mb-8 text-center">
          Buscar producte
        </h1>
        <input
          v-model="searchQuery"
          @input="fetchEmpreses"
          type="text"
          placeholder="Buscar empresa..."
          class="form-input mt-1 block w-full h-12 rounded px-4 border border-gray-300 mb-4"
        />
        <ul v-if="productes.length > 0">
          <li
            v-for="producte in productes"
            :key="producte.id"
            @click="mostrarDetalls(producte.id)"
            class="border-b border-gray-300 py-2"
          >
            {{ producte.nom }}
          </li>
        </ul>
        <p v-else class="text-gray-500">No s'han trobat resultats.</p>
      </div>
     <!-- Formulario de edición -->
    <div v-if="producteSeleccionat" class="mt-8 p-4 border rounded shadow">
      <h2 class="text-xl font-bold mb-4">Editar Empresa</h2>
      <form @submit.prevent="guardarCambios">
        <div class="mb-4">
          <label class="block text-gray-700" for="nom">Nom</label>
          <input
            id="nom"
            v-model="producteSeleccionat.nom"
            class="form-input mt-1 block w-full h-12 rounded px-4 border border-gray-300"
            type="text"
          />
        </div>

        <div class="mb-4">
          <label class="block text-gray-700" for="ciff">CIFF</label>
          <input
            id="ciff"
            v-model="empresaSeleccionada.CIFF"
            class="form-input mt-1 block w-full h-12 rounded px-4 border border-gray-300"
            type="text"
          />
        </div>

        <div class="mb-4">
          <label class="block text-gray-700" for="direccio">Direcció</label>
          <input
            id="direccio"
            v-model="empresaSeleccionada.direcció"
            class="form-input mt-1 block w-full h-12 rounded px-4 border border-gray-300"
            type="text"
          />
        </div>

        <div class="mb-4">
          <label class="block text-gray-700" for="descripcio">Descripció</label>
          <textarea
            id="descripcio"
            v-model="empresaSeleccionada.descripcio"
            class="form-textarea mt-1 block w-full rounded px-4 border border-gray-300"
            rows="4"
          >
        </textarea>
        </div>

        <button
          class="bg-blue-500 text-white py-2 px-4 rounded hover:bg-blue-700"
          type="submit"
        >
          Guardar Cambis
        </button>
      </form>
    </div>
    </div>
  </template>
  
  <script>
  import axios from 'axios';
  
  export default {
    data() {
      return {
        searchQuery: '',
        productes: [],
        producteSeleccionat: null, // Inicializar con null o {}

      };
    },
    methods: {
      async fetchEmpreses() {
        if (this.searchQuery.length < 1) {
          this.empreses = [];
          return;
        }
  
        try {
          const response = await axios.get('http://localhost:8088/api/buscarProductes', {
            params: {
              query: this.searchQuery,
            },
          });
  
          this.productes = response.data.productes;
        } catch (error) {
          console.error(error.response?.data || error.message);
          this.productes = [];
        }
      },
      async mostrarDetalls(id) {
      try {
        const response = await axios.get(`http://localhost:8088/api/producte/${id}`);
        this.producteSeleccionat = response.data.producte; // Asignar los detalles de la empresa seleccionada
      } catch (error) {
        console.error(error.response?.data || error.message);
        alert('Error al cargar los detalles de la empresa.');
      }
    },
    async guardarCambios() {
      try {
        await axios.put(
          `http://localhost:8088/api/empresa/${this.empresaSeleccionada.id}`,
          this.empresaSeleccionada
        );
        alert('Empresa actualizada con éxito.');
        // Actualizar lista de empresas para reflejar los cambios
        this.empresaSeleccionada = null;
        this.fetchEmpreses();
      } catch (error) {
        console.error(error.response?.data || error.message);
        alert('Error al actualizar la empresa.');
      }
    },
    },
    
  };
  </script>
  
  <style scoped>
  /* Estilos para resaltar elementos */
ul li {
  cursor: pointer;
  transition: background-color 0.3s;
}
ul li:hover {
  background-color: #f0f0f0;
}
  </style>
  