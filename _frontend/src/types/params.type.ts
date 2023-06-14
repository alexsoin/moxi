export type Addons = {
	[key: string]: string[];
}

export interface IParams {
	addons: Addons;
	settings: {
		[key: string]: string | number;
	};
}
