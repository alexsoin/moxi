<script setup lang="ts">
defineProps<{
	show: boolean,
	modalTitle: string,
	modalData: string[],
}>();

defineEmits(["closeModal"]);
</script>

<template>
	<Teleport to="body">
		<div
			v-if="show"
			class=""
		>
			<div class="fixed inset-0 bg-gray-900 opacity-60" />
			<div class="fixed inset-0 flex items-center justify-center">
				<div class="relative bg-gray-600 max-w-4xl w-full mx-auto px-6 py-8 rounded shadow-lg">
					<button
						class="absolute -top-3 -right-3 bg-gray-600 p-1 rounded-full text-gray-200 hover:text-opacity-75"
						@click.prevent="() => $emit('closeModal')"
					>
						<svg
							xmlns="http://www.w3.org/2000/svg"
							fill="none"
							viewBox="0 0 24 24"
							stroke-width="1.5"
							stroke="currentColor"
							class="w-8 h-8"
						>
							<path
								stroke-linecap="round"
								stroke-linejoin="round"
								d="M9.75 9.75l4.5 4.5m0-4.5l-4.5 4.5M21 12a9 9 0 11-18 0 9 9 0 0118 0z"
							/>
						</svg>
					</button>
					<div class="text-4xl font-bold pb-2 mb-10 text-gray-300">
						{{ modalTitle }}
					</div>
					<div class="max-h-[calc(100vh-12rem)] overflow-auto flex flex-col gap-2">
						<div
							v-for="itemData in modalData"
							:key="'itemData-'+itemData"
							class=""
						>
							{{ itemData }}
						</div>
						<div
							v-if="modalData.length === 0"
							class="text-center"
						>
							Пусто
						</div>
					</div>
				</div>
			</div>
		</div>
	</Teleport>
</template>
