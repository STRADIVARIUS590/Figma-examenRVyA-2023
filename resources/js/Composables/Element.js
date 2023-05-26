import { reactive, ref } from "vue";

export default function useInterface() {

    const hexToRgb = (hex) =>{
        var result = hex.slice(1).match(/.{1,2}/g);

        return result ? {
            r: parseInt(result[0], 16),
            g: parseInt(result[1], 16),
            b: parseInt(result[2], 16),
        } : {
            r: 0,
            g: 0,
            b : 0,
        }
    }

    const lastIndex = ref(0);

    const mouse = reactive({
        x: 0,
        y: 0,
        relx: 0,
        rely: 0,
        type: 'none',
        selection_index: -1,
        action: 'move',
    })

    const project = ref({
        name: "",
        figures: [],
    });

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

    const selectFigure = (index) => {

        var selected_figure = project.value.figures.find((figure) => figure.index == index)

        Object.assign(mouse, 
            {
                type: "none",
                selection_index: index,
                action: "move",
                relx: mouse.x - selected_figure.x,
                rely: mouse.y - selected_figure.y,
            }
        );
    }

    const addElement = (id) => {

        project.value.figures.forEach((figure) => {

            if(lastIndex.value <= figure.index) lastIndex.value = figure.index + 1
        })

        project.value.figures.unshift({
            index: lastIndex.value,
            type: mouse.type,
            x: Number(mouse.x?.toFixed(0)),
            y: Number(mouse.y?.toFixed(0)),
            h: 50,
            w: 60,
            name: mouse.type + "(" + project.value.figures.length + ")",
            color: "#000000",
            opacity: 100,
            border_size: 2,
            border_color: "#000000",
            border_opacity: 100,
            radius_corner: 0,
            font_size: 25,
            text: "Texto",
            visible: 1,
            deleted: 0,
            draw_id: id,
        });

        cleanMouseQueue();
        selectFigure(lastIndex.value);
    }

    const deleteElement = (index) =>{
        let indexFigure = project.value.figures.findIndex(figure => figure.index === index)  
        if(indexFigure >= 0){
            project.value.figures[indexFigure].deleted = 1;
            Object.assign(mouse, 
                {        
                    type: 'none',
                    action: 'move',
                    selection_index: -1,
                }
            );
        }
    }

    const drawFigure = (figure, p) =>{
        if(figure.visible && !figure.deleted){

            if(figure.index == mouse.selection_index){
                p.stroke(0, 0, 200, 1000)
                p.strokeWeight(1);
                p.fill(0,0,0, 0);

                var x,y,x2,y2;

                switch(figure.type){
                    case 'rect': case 'line':
                        x = figure.x - 5
                        y = figure.y - 5
                        x2 = figure.w + 10
                        y2 = figure.h + 10
                        break;
                    case 'ellipse':
                        x = figure.x - figure.w/2 - 5
                        y = figure.y - figure.h/2 - 5
                        x2 = figure.w + 10
                        y2 = figure.h + 10
                        break;
                    case 'text':
                        x = figure.x - 5
                        y = figure.y - figure.font_size
                        x2 = figure.w + 10
                        y2 = figure.h - (figure.font_size/2)
                        break;
                }
                p.rect(x,y,x2,y2);
            }

            //Borde
            var border_color = hexToRgb(figure.border_color);
            p.stroke(border_color.r, border_color.g, border_color.b, (figure.border_opacity / 100) * 255)
            p.strokeWeight(figure.border_size);
            //Relleno
            var color = hexToRgb(figure.color);
            p.fill(color.r, color.g, color.b, (figure.opacity / 100 ) * 255)

            switch(figure.type){
                case 'rect':
                    p.rect(figure.x,figure.y,figure.w,figure.h, figure.radius_corner)
                    break;
                case 'ellipse':
                    p.ellipse(figure.x,figure.y,figure.w,figure.h)
                    break;
                case 'line':
                    p.line(figure.x,figure.y,(figure.x + figure.w),(figure.y + figure.h))
                    break;
                case 'text':
                    p.textSize(figure.font_size);
                    p.text(figure.text,figure.x,figure.y)
                    break;
            }
        }
    }

    const moveLayer = (index, dir) => {

        let indexFigure = project.value.figures.findIndex(figure => figure.index === index);
        
        let box = project.value.figures[indexFigure];

        project.value.figures[indexFigure] = project.value.figures[indexFigure + dir];

        project.value.figures[indexFigure + dir] = box;

    };

    return {
        mouse,
        project,
        cleanMouseQueue,
        addElement,
        deleteElement,
        selectAction,
        drawFigure,
        selectFigure,
        moveLayer,
        lastIndex
    }
}
