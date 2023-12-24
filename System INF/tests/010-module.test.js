const systeminformation = require('systeminformation');
const serverModule = require('../src');

jest.mock('systeminformation');

const OPTION_EXAMPLES = [
    [
        'array',
        ['I', 'am', 'a', 'array']
    ],
    [
        'number',
        3.14
    ],
    [
        'boolean',
        false
    ],
    [
        'string',
        'I am a string'
    ],
    [
        'function',
        () => null
    ],
    [
        'null',
        null
    ],
    [
        'undefined',
        undefined
    ]
];

describe('Test simple module behaviour', () => {
    it('should resolve with empty object when an empty object as options is given', async () => {
        expect(await serverModule({})).toMatchObject({});
    });

    it.each(OPTION_EXAMPLES)('should reject when given options is %s', async (_name, value) => {
        expect(serverModule(value)).rejects.toThrow();
    });
});


const DEFAULT_SYSTEM_MOCK = {
    manufacturer: 'Generic',
    model: 'Generic model',
    version: '1.0',
    serial: '12345',
    uuid: '1234-abcd',
    sku: '-'
};

const DEFAULT_MEM_MOCK = {
    total: 123671237,
    free: 23423478,
    used: 100247759
};

const PASS_WITH_OPTIONS = [
    [
        'correct function name and no filtering',  // description
        { system: [] },  // option argument
        DEFAULT_SYSTEM_MOCK,  // mocked return value of systeminformation
        { _fields: ['system'], system: DEFAULT_SYSTEM_MOCK }  // expected return object
    ],
    [
        'correct function name and 1 filtered result',
        { system: ['manufacturer'] },
        DEFAULT_SYSTEM_MOCK,
        { _fields: ['system'], system: { manufacturer: DEFAULT_SYSTEM_MOCK['manufacturer'] } }
    ],
    [
        'correct function name and 2 filtered results',
        { system: ['manufacturer', 'version'] },
        DEFAULT_SYSTEM_MOCK,
        { _fields: ['system'], system: { manufacturer: DEFAULT_SYSTEM_MOCK['manufacturer'], version: DEFAULT_SYSTEM_MOCK['version'] } }
    ]
];

describe('Test systeminformation calls and filtering', () => {
    it('should reject when a function name is given that is not available in the systeminformation package', async () => {
        expect(serverModule({ invalidFunction: [] })).rejects.toThrow();
    });

    it('should pass when a function name is given that is available in the systeminformation package', async () => {
        systeminformation.system.mockResolvedValue(DEFAULT_SYSTEM_MOCK);
        expect(await serverModule({ system: [] })).toMatchObject({ _fields: ['system'], system: DEFAULT_SYSTEM_MOCK });
        expect(systeminformation.system).toHaveBeenCalled();
    });

    it('should reject when a available function and a invalid filter element is given', async () => {
        systeminformation.system.mockResolvedValue(DEFAULT_SYSTEM_MOCK);
        expect(serverModule({ system: ['notAElement'] })).rejects.toThrow();
        expect(systeminformation.system).toHaveBeenCalled();
    });


    it.each(PASS_WITH_OPTIONS)('should pass with %s', async (_desc, options, mock, expected) => {
        systeminformation.system.mockResolvedValue(mock);

        const result = await serverModule(options);

        expect(result).toMatchObject(expected);
        expect(systeminformation.system).toHaveBeenCalled();
    });

    it('should pass when more than one available function name is given with no filters', async () => {
        systeminformation.system.mockResolvedValue(DEFAULT_SYSTEM_MOCK);
        systeminformation.mem.mockResolvedValue(DEFAULT_MEM_MOCK);

        const result = await serverModule({ system: [], mem: [] });

        expect(result).toMatchObject({
            _fields: [
                'system',
                'mem'
            ],
            system: DEFAULT_SYSTEM_MOCK,
            mem: DEFAULT_MEM_MOCK
        });
        expect(systeminformation.system).toHaveBeenCalled();
        expect(systeminformation.mem).toHaveBeenCalled();
    });

    it('should pass when more than one available function name is given with setted filters', async () => {
        systeminformation.system.mockResolvedValue(DEFAULT_SYSTEM_MOCK);
        systeminformation.mem.mockResolvedValue(DEFAULT_MEM_MOCK);

        const result = await serverModule({ system: ['uuid'], mem: ['free'] });

        expect(result).toMatchObject({
            _fields: [
                'system',
                'mem'
            ],
            system: {
                uuid: DEFAULT_SYSTEM_MOCK['uuid']
            },
            mem: {
                free: DEFAULT_MEM_MOCK['free']
            }
        });
        expect(systeminformation.system).toHaveBeenCalled();
        expect(systeminformation.mem).toHaveBeenCalled();
    });
});