const si = require('systeminformation');

/**
 * A module for the server-state system
 * 
 * A module to view characteristics of your system
 * 
 * @throws if anything than 'object' given as options
 * @throws if the key in options is not a function of the systeminformation module
 * @throws if an invalid filter is given for the specified function
 * 
 * @param {object} options object with functions for the systeminformation module to check as keys and 
 *        arrays as filters for these functions
 * @returns {object} A JSON-serializable (via `JSON.stringify()`) version information about the server state
 */
module.exports = async function (options) {
    if (typeof options !== 'object' || Array.isArray(options))
        throw new Error('Type of options is not \'object\' but \'' + (Array.isArray(options) ? 'array' : typeof options) + '\'.');

    let result = { _fields: [] };

    for (const [key, value] of Object.entries(options)) {
        if (typeof si[key] !== 'function')
            throw new Error('The function \'' + key + '\' is not available in the systeminformation package.');

        const info = await si[key]();

        // if additional value is given -> filter:
        if (value.length > 0) {
            result[key] = {};
            for (const element of value) {
                if (typeof info[element] === 'undefined')
                    throw new Error('Invalid filter \'' + element + '\' for results of function \'' + key + '\'.');
                result[key][element] = info[element];
            }
        } else {
            result[key] = info;
        }
        result._fields.push(key);
    }

    return result;
};