<template>
  <div class="container mx-auto px-4 py-8">
    <div class="flex justify-between items-center mb-8">
      <h1 class="text-2xl font-bold">Gerenciar Experiências Profissionais</h1>
      <button @click="openModal" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
        Adicionar Experiência
      </button>
    </div>

    <div class="bg-white shadow rounded-lg overflow-hidden">
      <table class="min-w-full divide-y divide-gray-200">
        <thead class="bg-gray-50">
          <tr>
            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Empresa</th>
            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Cargo</th>
            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Período</th>
            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Ordem</th>
            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Ações</th>
          </tr>
        </thead>
        <tbody class="bg-white divide-y divide-gray-200">
          <tr v-for="exp in experiences" :key="exp.id">
            <td class="px-6 py-4 whitespace-nowrap">{{ exp.company }}</td>
            <td class="px-6 py-4 whitespace-nowrap">{{ exp.position }}</td>
            <td class="px-6 py-4 whitespace-nowrap">
              {{ formatDate(exp.start_date) }} - {{ exp.is_current ? 'Atual' : formatDate(exp.end_date) }}
            </td>
            <td class="px-6 py-4 whitespace-nowrap">{{ exp.display_order }}</td>
            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
              <button @click="editExperience(exp)" class="text-blue-600 hover:text-blue-900 mr-4">Editar</button>
              <button @click="deleteExperience(exp.id)" class="text-red-600 hover:text-red-900">Excluir</button>
            </td>
          </tr>
        </tbody>
      </table>
    </div>

    <!-- Modal de Edição/Criação -->
    <ExperienceModal 
      v-if="showModal"
      :experience="currentExperience"
      @close="closeModal"
      @save="saveExperience"
    />
  </div>
</template>

<script setup>
import { ref, onMounted } from 'vue';
import { useExperienceStore } from '@/stores/experienceStore';
import ExperienceModal from '@/components/Admin/ExperienceModal.vue';

const experienceStore = useExperienceStore();
const { experiences, loading, error, fetchExperiences } = experienceStore;

const showModal = ref(false);
const currentExperience = ref(null);

onMounted(() => {
  fetchExperiences();
});

const formatDate = (dateString) => {
  if (!dateString) return '';
  const date = new Date(dateString);
  return date.toLocaleDateString('pt-BR');
};

const openModal = (exp = null) => {
  currentExperience.value = exp 
    ? { ...exp } 
    : { 
        company: '',
        position: '',
        description: '',
        start_date: new Date().toISOString().split('T')[0],
        end_date: null,
        is_current: false,
        responsibilities: [],
        display_order: 0
      };
  showModal.value = true;
};

const closeModal = () => {
  showModal.value = false;
};

const saveExperience = async (expData) => {
  try {
    if (expData.id) {
      await axios.put(`/experiences/${expData.id}`, expData);
    } else {
      await axios.post('/experiences', expData);
    }
    await fetchExperiences();
    closeModal();
  } catch (err) {
    console.error('Error saving experience:', err);
  }
};

const editExperience = (exp) => {
  openModal(exp);
};

const deleteExperience = async (id) => {
  if (confirm('Tem certeza que deseja excluir esta experiência?')) {
    try {
      await axios.delete(`/experiences/${id}`);
      await fetchExperiences();
    } catch (err) {
      console.error('Error deleting experience:', err);
    }
  }
};
</script>