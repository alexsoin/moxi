import { Addons } from "@/types/params.type";

export interface IList {
	addons: Addons,
	siteName: string,
	managerName: string,
	removeApp: boolean
}

export type EventData = Array<any> | object | string | null;
