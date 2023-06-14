<script setup lang="ts">
import { ref } from "vue";

const props = defineProps<{
	label: string,
	btnType?: "primary"|"secondary",
}>();

const styles = {
	primary: "text-orange-400 border-2 border-orange-400 focus-visible:bg-orange-300 hover:bg-orange-300",
	secondary: "text-teal-400 border-2 border-teal-400 focus-visible:bg-teal-300 hover:bg-teal-300",
};
const styleNow = ref(props.btnType && props.btnType in styles ? styles[props.btnType] : styles["primary"]);
</script>

<template>
	<button
		class="rounded px-20 py-2 transition-colors outline-none hover:bg-opacity-10 focus-visible:bg-opacity-10"
		:class="styleNow"
	>
		{{ label }}
	</button>
</template>
