<script setup>
import {ref} from "vue";

const props = defineProps({});

const position = ref({ x: 0, y:0 });
const container = ref(null);
const isVisible = ref(false);
const onMouseOver = (event) => {
    isVisible.value = true;
    const offset = {x: 5, y: 20};
    position.value = {x: event.clientX + offset.x , y: event.clientY + offset.y};
}

const onMouseOut = () => {
    isVisible.value = false;
}
</script>

<template>
    <div @mousemove="onMouseOver" @mouseout="onMouseOut" class="relative w-full h-full" >
        <slot/>
        <teleport to="body">
            <div class=" fixed" :style="{'display': isVisible? 'block' :'none','z-index': 9999999999,'top': position.y+'px' , 'left': position.x+'px'}">
                <slot name="overlay"/>
            </div>
        </teleport>
    </div>
</template>
