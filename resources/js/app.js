import './bootstrap';

import { createApp } from "vue/dist/vue.esm-bundler";

import ProjectsIndex from "./Pages/Projects/Index.vue";

import { provide } from 'vue';

const app = createApp({
    components: {
        ProjectsIndex,
    },
    setup() {
        provide(
            "csrf",
            document
                .querySelector('meta[name="csrf-token"]')
                .getAttribute("content")
        );
    },
});
app.mixin(
    {
        methods:{
            route,
            formatDateHourTextShort(date){
                var monthNames = [
                  "Ene",
                  "Feb",
                  "Mar",
                  "Abr",
                  "May",
                  "Jun",
                  "Jul",
                  "Ago",
                  "Sep",
                  "Oct",
                  "Nov",
                  "Dic",
                ];
                var d = new Date(date),
                  month = "" + monthNames[d.getMonth()],
                  day = "" + d.getDate(),
                  year = d.getFullYear(),
                  hours = d.getHours(),
                  mins = d.getMinutes(),
                  time = 'AM';
        
                if (month.length < 2) month = "0" + month;
                if (day.length < 2) day = "0" + day;
                
                if(hours == 24) {
                    hours = 0
                }
                if(hours >= 12) {
                    time = 'PM'
                    hours -= 12
                }
        
                if (hours < 10) hours = "0" + hours;
                if (mins < 10) mins = "0" + mins;
                
                return (day + " " + month + ' ' + year + ', ' + hours + ':' + mins + time);
            }
        }
    }
);
  
app.mount("#app");