import {Type} from 'main.core';

export class CheckControlOpenWorkDay
{
	constructor(options = {name: 'CheckControlOpenWorkDay'})
	{
		this.name = options.name;
	}

	setName(name)
	{
		if (Type.isString(name))
		{
			this.name = name;
		}
	}

	getName()
	{
		return this.name;
	}


	getConsole()
	{
		console.log("Все работает");
	}



}
