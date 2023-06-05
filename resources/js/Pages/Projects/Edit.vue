<template>
    <div class="px-4 py-2 w-100 headerBar text-light">
        <div class="row">
            <div class="col-4 d-flex flex-wrap">
                    <h1 class="mt-2 me-2 font titleName" data-bs-toggle="tooltip" data-bs-placement="bottom" title="Inicio">
                        <a :href="route('projects')">
                            <b>
                                SG
                            </b>
                        </a>
                    </h1>
                    <button @click="selectAction('none', 'move')"
                    class="btn" data-bs-toggle="tooltip" data-bs-placement="bottom" title="Mover">
                        <i class="toolbar-icon text-light fa-solid fa-arrow-pointer"></i>
                    </button>
                    <button @click="selectAction('none', 'resize')"
                    class="btn" data-bs-toggle="tooltip" data-bs-placement="bottom" title="Cambiar tamaño">
                        <i class="toolbar-icon text-light fa-solid fa-down-left-and-up-right-to-center"></i>
                    </button>
                    <button @click="selectAction('rect')"
                    class="btn" data-bs-toggle="tooltip" data-bs-placement="bottom" title="Rectángulo">
                        <i class="toolbar-icon text-light fa-regular fa-square"></i>
                    </button>
                    <button @click="selectAction('ellipse')"
                    class="btn" data-bs-toggle="tooltip" data-bs-placement="bottom" title="Elipse">
                        <i class="toolbar-icon text-light fa-regular fa-circle"></i>
                    </button>
                    <button @click="selectAction('line')"
                    class="btn" data-bs-toggle="tooltip" data-bs-placement="bottom" title="Línea">
                        <i class="toolbar-icon text-light fa-solid fa-lines-leaning"></i>
                    </button>
                    <button @click="selectAction('text')"
                    class="btn" data-bs-toggle="tooltip" data-bs-placement="bottom" title="Texto">
                        <i class="toolbar-icon text-light fa-solid fa-font"></i>
                    </button>
            </div>
            <div class="mt-2 col-4 text-center px-5">
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
            <div class="col-4 d-flex flex-wrap justify-content-end">
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
            <div class="row w-100 mx-0" v-for="(figure, index) in project.figures" :key="figure.index">
                <template v-if="!figure.deleted">
                    <div class="col">
                        <div role="button" :class="'ps-2 py-2 me-2 ' + (mouse.selection_index == figure.index ? 'text-light' : '')"
                        @click="selectFigure(figure.index)">
                            <h6>{{ figure.name }}</h6>
                        </div>
                    </div>
                    <div class="col d-flex d-inline-flex justify-content-end">
                        <template v-if="project.figures.length > 1">
                            <button @click="moveLayer(figure.index, 1)" class="btn p-1 m-0" v-if="index < project.figures.length-1">
                                <i :class="(mouse.selection_index == figure.index ? 'text-light' : 'text-dark') + 
                                ' fa-solid fa-chevron-down'"
                                data-bs-toggle="tooltip" data-bs-placement="top" title="Mover una capa hacia atrás"></i>
                            </button>
                            <button @click="moveLayer(figure.index, -1)" class="btn p-1 m-0" v-if="index > 0">
                                <i :class="(mouse.selection_index == figure.index ? 'text-light' : 'text-dark') + 
                                ' fa-solid fa-chevron-up'"
                                data-bs-toggle="tooltip" data-bs-placement="top" title="Mover una capa hacia adelante"></i>
                            </button>
                        </template>
                        <button @click="figure.visible = (figure.visible == 1 ? 0 : 1)" class="btn p-1 m-0">
                            <i :class="(mouse.selection_index == figure.index ? 'text-light' : 'text-dark') + 
                            ' fa-solid fa-eye'" v-if="figure.visible"
                            data-bs-toggle="tooltip" data-bs-placement="top" title="Ocultar"></i>
                            <i :class="(mouse.selection_index == figure.index ? 'text-light' : 'text-dark') + 
                            ' fa-solid fa-eye-slash'" v-else
                            data-bs-toggle="tooltip" data-bs-placement="top" title="Mostrar"></i>
                        </button>
                    </div>
                </template>
            </div>
        </div>
        <div class="col-2 ms-auto sidebar">
            <div class="p-3" v-if="selected_figure">
                <div class="row">
                    <div class="mb-4 col-12">
                        <label><b>Nombre</b></label>
                        <input type="text" v-model="selected_figure.name" class="form-control">
                    </div>

                    <div class="mb-4 col-12" v-if="selected_figure.type=='text'">
                        <label><b>Texto</b></label>
                        <textarea v-model="selected_figure.text" class="form-control" />
                    </div>
                    <div class="mb-4 col-12" v-if="selected_figure.type=='text'">
                        <label><b>Tamaño de fuente</b></label>
                        <input type="number" class="form-control" v-model="selected_figure.font_size" step="1"
                        onkeypress="return event.charCode >= 48 && event.charCode <= 57">
                    </div>

                    <div class="mb-2 mt-1 col-12">
                        <label><b>Dimensiones</b></label>
                    </div>

                    <label class="mb-2 col-2 py-1"><b>x:</b></label>
                    <div class="mb-2 col-10">
                        <input type="number" class="form-control" v-model="selected_figure.x" step="1"
                        onkeypress="return event.charCode >= 48 && event.charCode <= 57">
                    </div>

                    <label class="mb-2 col-2 py-1"><b>y:</b></label>
                    <div class="mb-2 col-10">
                        <input type="number" class="form-control" v-model="selected_figure.y" step="1"
                        onkeypress="return event.charCode >= 48 && event.charCode <= 57">
                    </div>

                    <label class="mb-2 col-2 py-1"><b>w:</b></label>
                    <div class="mb-2 col-10">
                        <input type="number" class="form-control" v-model="selected_figure.w" step="1"
                        onkeypress="return event.charCode >= 48 && event.charCode <= 57">
                    </div>

                    <label class="mb-2 col-2 py-1"><b>h:</b></label>
                    <div class="mb-2 col-10">
                        <input type="number" class="form-control" v-model="selected_figure.h" step="1"
                        onkeypress="return event.charCode >= 48 && event.charCode <= 57">
                    </div>

                    <div class="mt-1 mb-2 col-12" v-if="selected_figure.type=='rect'">
                        <label><b>Radio de esquinas</b></label>
                        <input type="number" class="form-control" v-model="selected_figure.radius_corner" step="1"
                        onkeypress="return event.charCode >= 48 && event.charCode <= 57">
                    </div>

                    <div class="my-2 col-12">
                        <label><b>Color</b></label>
                    </div>
                    <div class="mb-2 col-4">
                        <input type="color" class="form-control form-control-color w-100" v-model="selected_figure.color" >
                    </div>
                    <div class="mb-2 col-6">
                        <input type="number" class="form-control" v-model="selected_figure.opacity" step="1"
                        onkeypress="return event.charCode >= 48 && event.charCode <= 57">
                    </div>
                    <label class="mb-2 col-2 py-1"><b>%</b></label>

                    <div class="my-2 col-12">
                        <label><b>Borde</b></label>
                    </div>
                    <div class="mb-2 col-4">
                        <input type="color" class="form-control form-control-color w-100" v-model="selected_figure.border_color" >
                    </div>
                    <div class="mb-2 col-6">
                        <input type="number" class="form-control" v-model="selected_figure.border_opacity" step="1"
                        onkeypress="return event.charCode >= 48 && event.charCode <= 57">
                    </div>
                    <label class="mb-2 col-2 py-1"><b>%</b></label>

                    <div class="mb-2 mt-1 col-12">
                        <label><b>Grosor de borde</b></label>
                        <input type="number" class="form-control" v-model="selected_figure.border_size" step="1"
                        onkeypress="return event.charCode >= 48 && event.charCode <= 57">
                    </div>
                </div>

                <button class="btn btn-danger mt-3 w-100" @click="deleteElement(selected_figure.index)">
                    <i class="me-2 text-light fa-solid fa-trash"></i>
                    Eliminar
                </button>
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
            clickFigure,
            moveLayer,
        } = useInterface();

        project.value = props.project;

        const editName = ref(false);

        const canvasMousePressed = () => {
            if(mouse.type != 'none') {
                addElement(project.value.id)
            }else{
                clickFigure();
            }
        }
        const canvasMouseReleased = () => {
            selectFigure(mouse.selection_index)
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
                canvas.mousePressed(canvasMousePressed)
                canvas.mouseReleased(canvasMouseReleased)
            }

            p.draw = function() {

                mouse.x = p.mouseX;
                mouse.y = p.mouseY;
                
                p.background('#888888')

                let copyArray = project.value.figures.map(fig =>{ return fig })

                copyArray.reverse().forEach((figure) =>{
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
                .then((response) => {

                    project.value.figures = response.data.data.figures;
                    
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
            moveLayer,
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
    overflow: auto;
}
.titleName
{
    font-size: 35px;
    font-family: 'Yeseva One';
    font-style: normal;
    font-weight: 400;
}
.toolbar-icon
{
    font-size: 30px;
}
a{
    text-decoration: none;
    color: #FFFFFF;
}
</style>