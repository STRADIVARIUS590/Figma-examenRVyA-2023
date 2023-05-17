import { reactive, ref } from "vue";

export default function useInterface() {

    const hexToRgb = (hex) =>{
        return{
            r: 0,
            g: 0,
            b: 0,
        }
    }

    const mouse = reactive({
        x: 0,
        y: 0,
        relx: 0,
        rely: 0,
        type: 'none',
        selection_index: -1,
        action: 'move',
    })

    const figures = ref([]);

    const cleanMouseQueue = () =>{
        Object.assign(mouse, 
            {        
                type: 'none',
                action: 'move',
            }
        );
    }

    const selectAction = (type = 'none', action = 'add') =>{
        Object.assign(mouse, 
            {
                type: type,
                selection_index: -1,
                action: action,
            }
        );
    }

    const addElement = () => {
        figures.value.push({
            index: figures.value.length,
            type: mouse.type,
            x: mouse.x,
            y: mouse.y,
            h: 150,
            w: 50,
            color: "#000000",
            opacity: 0,
            border_size: 1,
            border_color: "#000000",
            border_opacity: 100,
            radius_corner: 0,
            font_size: 20,
            text: "",
            visible: 1,
        });

        cleanMouseQueue();
    }

    const deleteElement = (index) =>{
        figures.value.splice(index,1);
    }

    const drawFigure = (figure, p) =>{
        if(figure.visible){
            //Borde
            var border_color = hexToRgb(figure.border_color);
            p.stroke(border_color.r, border_color.g, border_color.b, figure.border_opacity)
            p.strokeWeight(figure.border_size);
            //Relleno
            var color = hexToRgb(figure.color);
            p.fill(color.r, color.g, color.b, figure.opacity)

            switch(figure.type){
                case 'rect':
                    p.rect(figure.x,figure.y,figure.w,figure.h)
                    break;
                case 'ellipse':
                    p.ellipse(figure.x,figure.y,figure.w,figure.h)
                    break;
                case 'line':
                    p.line(figure.x,figure.y,(figure.x + figure.w),(figure.y + figure.h))
                    break;
                case 'text':
                    p.text(figure.text,figure.x,figure.y)
                    break;
            }
        }
    }

    return {
        mouse,
        figures,
        cleanMouseQueue,
        addElement,
        deleteElement,
        selectAction,
        drawFigure,
    }
}
