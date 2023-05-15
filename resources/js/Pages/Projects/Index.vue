<template>
    <div class="px-4 py-2 mb-4 w-100 headerBar text-light d-flex">
        <h3 class="mt-2 col">{{ user.name }} {{ user.lastname }}</h3>

        <div class="mt-2">
            <input type="text" class="form-control" placeholder="Buscar..." v-model="searchString">
        </div>
        
        <form class="col-ms-auto ms-3" :action="route('logout')" method="POST">
            <button type="submit" class="btn" data-bs-toggle="tooltip" data-bs-placement="bottom" title="Cerrar Sesión">
                <i class="display-6 text-light fa-solid fa-right-from-bracket"></i>
            </button>
            <input type="hidden" name="_token" :value="csrf" />
        </form>
    </div>
    <div class="row w-100 px-5">
        <div class="col-3" v-for="(project, index) in filteredProjects" :key="project.id">
            <div class="card p-3 h-100">
                <a :href="route('draws.show', project.id)">
                    <h5>{{ project.name }}</h5>
                    <h6 class="text-muted"> Abierto el {{ formatDateHourTextShort(project.updated_at) }}</h6>
                </a>
                <button class="btn btn-danger mt-2" @click="destroy(project.id, index)">
                    <i class="me-2 text-light fa-solid fa-trash"></i>
                    Eliminar
                </button>
            </div>
        </div>
        <div class="col-3">
            <div class="card p-3 h-100">
                <a :href="route('draws.store')">
                    <h5>Nuevo proyecto</h5>
                    <h6 class="text-muted"> Crea un proyecto en blanco</h6>
                    <button class="btn btn-success mt-2 w-100">
                        <i class="me-2 text-light fa-solid fa-plus"></i>
                        Crear
                    </button>
                </a>
            </div>
        </div>
        <div class="col-12 mt-4">
            <h6 class="text-muted"> Mostrando {{ filteredProjects.length }} de {{ projects.length }} proyectos</h6>
        </div>
    </div>
</template>

<script>
import { computed, inject, ref } from 'vue';
export default {
    components:{
    },
    props:{
        user: Object,
        projects: Array,
    },
    setup(props) {

        const projects = ref(props.projects);
        const searchString = ref("");

        projects.value.forEach(project => {
            project.image = JSON.parse(project.image)
        })

        const filteredProjects = computed(() => {
            return projects.value.filter((project) => {
                var filter = true;

                if(searchString.value.length> 0){
                    filter = project.name.toUpperCase().includes(searchString.value.toUpperCase())
                }

                return filter;
            })
        })

        const destroy = async (id, index) => {
            Swal.fire({
                title: "¿Estas seguro?",
                text: "Una vez eliminado, no podras revertir esto.",
                icon: "warning",
                showCancelButton: true,
                cancelButtonText: `Cancelar`,
            }).then((result) => {
                if (result.isConfirmed) {
                    axios
                        .delete(route('draws.destroy', id))
                        .then(() => {
                            Swal.fire(
                                "Hecho",
                                "Registro eliminado correctamente",
                                "success"
                            ).then(() => {
                                projects.value.splice(index, 1)
                            });
                        })
                        .catch(() => {
                            Swal.fire(
                                "Error",
                                "No encontramos lo que buscaba!",
                                "error"
                            );
                        });
                }
            });
        };

        return{
            projects,
            searchString,
            csrf: inject('csrf'),
            filteredProjects,
            destroy,
        }
    },
}
</script>

<style scoped>
.headerBar{
    background: linear-gradient(180deg, #AF259A 0%, #132843 100%);
}
a{
    text-decoration: none;
}
.card{
    cursor: pointer;
}
.card:hover {
  box-shadow: 0 0 11px rgba(33,33,33,.2); 
}
</style>