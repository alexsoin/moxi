<script setup lang="ts">
import { computed } from "vue";

const props = defineProps<{
	modelValue: boolean | string | string[],
	value?: boolean|object,
	label: string,
}>();
const emit = defineEmits<{
	(e: "update:modelValue", val: boolean | string | string[]): void,
}>();

const model = computed({
	get() {
		return props.modelValue;
	},
	set(value) {
		emit("update:modelValue", value);
	},
});
</script>

<template>
	<label
		class="inline-flex items-center"
	>
		<input
			v-model="model"
			:value="value || label"
			type="checkbox"
			class="outline-none rounded text-orange-600 border-2 border-gray-400 focus-visible:border-orange-300"
		>
		<span class="ml-2">{{ label }}</span>
	</label>
</template>

<style lang="scss" scoped>
input {
	&[type="checkbox"] {
		@apply w-6;
		@apply h-6;
		appearance: none;
		display: grid;
		place-content: center;

		&::before {
			content: "";
			@apply w-3;
			@apply h-3;
			clip-path: polygon(14% 44%, 0 65%, 50% 100%, 100% 16%, 80% 0%, 43% 62%);
			transform: scale(0);
			box-shadow: inset 1em 1em currentColor;
		}

		&:checked::before {
			transform: scale(1);
		}
	}
}
</style>
