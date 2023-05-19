<template>
    <div class="px-4 py-2 w-100 headerBar text-light">
        <div class="row">
            <div class="col-3">
                <div class="d-flex">
                    <button @click="selectAction('none', 'move')"
                    class="btn" data-bs-toggle="tooltip" data-bs-placement="bottom" title="Mover">
                        <i class="display-6 text-light fa-solid fa-arrow-pointer"></i>
                    </button>
                    <button @click="selectAction('rect')"
                    class="btn" data-bs-toggle="tooltip" data-bs-placement="bottom" title="Rectángulo">
                        <i class="display-6 text-light fa-regular fa-square"></i>
                    </button>
                    <button @click="selectAction('ellipse')"
                    class="btn" data-bs-toggle="tooltip" data-bs-placement="bottom" title="Elipse">
                        <i class="display-6 text-light fa-regular fa-circle"></i>
                    </button>
                    <button @click="selectAction('line')"
                    class="btn" data-bs-toggle="tooltip" data-bs-placement="bottom" title="Línea">
                        <i class="display-6 text-light fa-solid fa-lines-leaning"></i>
                    </button>
                    <button @click="selectAction('text')"
                    class="btn" data-bs-toggle="tooltip" data-bs-placement="bottom" title="Texto">
                        <i class="display-6 text-light fa-solid fa-font"></i>
                    </button>
                </div>
            </div>
            <div class="mt-2 col-6 text-center">
                <input 
                    v-if="editName"
                    type="text" 
                    class="form-control"
                    v-model="project.name"
                    @focusout="finishEdit()" 
                    @keydown.enter="finishEdit()" 
                />
                <h3 v-else
                    @click="editName = true"
                >
                    {{ project.name }}
                </h3>
            </div>
            <div class="col-3 d-flex justify-content-end">
                <button class="btn" data-bs-toggle="tooltip" data-bs-placement="bottom" title="Guardar"
                    @click="save()">
                    <i class="display-6 text-light fa-solid fa-floppy-disk"></i>
                </button>
                <form class="col-ms-auto ms-3" :action="route('logout')" method="POST">
                    <button type="submit" class="btn" data-bs-toggle="tooltip" data-bs-placement="bottom" title="Cerrar Sesión">
                        <i class="display-6 text-light fa-solid fa-right-from-bracket"></i>
                    </button>
                    <input type="hidden" name="_token" :value="csrf" />
                </form>
            </div>
        </div>
    </div> 

    <div class="row w-100 mx-0">
        <div class="col-2 sidebar">
            <div class="row w-100 mx-0" v-for="figure in project.figures" :key="figure.index">
                <div class="col-9">
                    <div role="button" :class="'ps-4 py-2 ' + (mouse.selection_index == figure.index ? 'text-light' : '')"
                    @click="selectFigure(figure.index)">
                        <h6>{{ figure.name }}</h6>
                    </div>
                </div>
                <div class="col-3">
                    <button @click="figure.visible = (figure.visible == 1 ? 0 : 1)" class="btn">
                        <i :class="(mouse.selection_index == figure.index ? 'text-light' : 'text-dark') + 
                        ' fa-solid fa-eye'" v-if="figure.visible"
                        data-bs-toggle="tooltip" data-bs-placement="top" title="Ocultar"></i>
                        <i :class="(mouse.selection_index == figure.index ? 'text-light' : 'text-dark') + 
                        ' fa-solid fa-eye-slash'" v-else
                        data-bs-toggle="tooltip" data-bs-placement="top" title="Mostrar"></i>
                    </button>
                </div>
            </div>
        </div>
        <div class="col-2 ms-auto sidebar">
            <div class="p-3" v-if="selected_figure">
                <h4 class="text-center">{{ selected_figure.name }}</h4>
                <pre>{{ selected_figure }}</pre>
                <!--<template v-for="(attr, key, index) in selected_figure" :key="key" >
                    <input type="text" v-model="selected_figure[key]">
                </template>-->
            </div>
        </div>
    </div>
    
    <div id="sketch-holder"></div>
</template>

<script>
import useInterface from '@/Composables/Element.js'
import { computed, inject, ref } from 'vue';
export default {
    components:{
    },
    props:{
        user: Object,
        project: Object,
    },
    setup(props) {
        
        const {
            mouse,
            project,
            cleanMouseQueue,
            addElement,
            deleteElement,
            selectAction,
            drawFigure,
            selectFigure,
        } = useInterface();

        project.value = props.project;

        const editName = ref(false);

        const canvasClicked = () => {
            if(mouse.type != 'none') addElement(project.value.id)
        }

        let workspace = function(p) {

            p.setup = function() {
                let canvas =  p.createCanvas(p.windowWidth / 2 , p.windowHeight / 5 * 4);
                
                //  posicion de 0,0 del canvas respecto a toda la pantalla
                mouse.relx = p.windowWidth / 2 - (p.windowWidth / 4)
                mouse.rely = p.windowHeight / 2 - (p.windowHeight / 3)

                // posiciona el canvas en el centro de la pagina 
                canvas.position(mouse.relx, mouse.rely)
                canvas.parent('sketch-holder');
                canvas.mouseClicked(canvasClicked)
            }

            p.draw = function() {

                mouse.x = p.mouseX;
                mouse.y = p.mouseY;
                
                p.background('#888888')

                project.value.figures.forEach((figure) =>{
                    drawFigure(figure, p);
                });
            }
        };

        let myp5 = new p5(workspace);

        const selected_figure = computed(() => {
            return project.value.figures.find((figure) => figure.index == mouse.selection_index)
        })

        const finishEdit = () => {
            if(project.value.name.length > 0 && editName.value){
                editName.value = false;
                save();
            }
        }

        const save = () => {
            axios
                .put(route('projects.edit'), project.value)
                .then(() => {
                    Swal.fire(
                        "Hecho",
                        "Cambios guardados correctamente",
                        "success"
                    )
                })
        }

        return{
            myp5,
            csrf: inject('csrf'),
            mouse,
            project,
            cleanMouseQueue,
            addElement,
            deleteElement,
            selectAction,
            drawFigure,
            selectFigure,
            selected_figure,
            editName,
            save,
            finishEdit,
        }
    },
}
</script>

<style scoped>
.headerBar{
    background: #AB85D1;
}
.sidebar{
    background: #999999;
    height: 89.75vh;
}
</style>