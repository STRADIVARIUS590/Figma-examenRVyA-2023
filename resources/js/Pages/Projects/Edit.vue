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
                <h3>{{ project.name }}</h3>
            </div>
            <div class="col-3 d-flex justify-content-end">
                <button class="btn" data-bs-toggle="tooltip" data-bs-placement="bottom" title="Guardar">
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

    <div id="sketch-holder"></div>
</template>

<script>
import useInterface from '@/Composables/Element.js'
import { inject } from 'vue';
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
            figures,
            cleanMouseQueue,
            addElement,
            deleteElement,
            selectAction,
            drawFigure,
        } = useInterface();

        //figures.value = JSON.parse(props.project.image).figures;

        let workspace = function(p) {

            p.setup = function() {
                let canvas =  p.createCanvas(800, 550);
                
                //  posicion de 0,0 del canvas respecto a toda la pantalla
                mouse.relx = p.windowWidth / 2 - 400
                mouse.rely = p.windowHeight / 2 - 250

                // posiciona el canvas en el centro de la pagina 
                canvas.position(mouse.relx, mouse.rely)
                canvas.parent('sketch-holder');
            }

            p.draw = function() {

                mouse.x = p.mouseX;
                mouse.y = p.mouseY;
                
                p.background('#888888')

                figures.value.forEach((figure) =>{
                    drawFigure(figure, p);
                });
            }

            p.mouseClicked = function() {
                if(mouse.type != 'none') addElement()
            }
        };

        let myp5 = new p5(workspace);

        return{
            myp5,
            csrf: inject('csrf'),
            mouse,
            figures,
            cleanMouseQueue,
            addElement,
            deleteElement,
            selectAction,
            drawFigure,
        }
    },
}
</script>

<style scoped>
.headerBar{
    background: #AB85D1;
}
</style>