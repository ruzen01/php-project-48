# [Difference Calculator]

### Hexlet tests and linter status:
[![Actions Status](https://github.com/ruzen01/php-project-48/actions/workflows/hexlet-check.yml/badge.svg)](https://github.com/ruzen01/php-project-48/actions)
[![.github/workflows/main.yml](https://github.com/ruzen01/php-project-48/actions/workflows/main.yml/badge.svg?branch=main)](https://github.com/ruzen01/php-project-48/actions/workflows/main.yml)
[![Maintainability](https://api.codeclimate.com/v1/badges/96f763e45c2a6acf55e9/maintainability)](https://codeclimate.com/github/ruzen01/php-project-48/maintainability)
[![Test Coverage](https://api.codeclimate.com/v1/badges/96f763e45c2a6acf55e9/test_coverage)](https://codeclimate.com/github/ruzen01/php-project-48/test_coverage)

This package calculates the difference between two data files.

## Setup

```bash
git clone https://github.com/ruzen01/php-project-48.git
cd php-project-48
make install
```

# Usage
# As a CLI tool
To use the CLI tool, run:

```sh
gendiff file1.json file2.json
```

Options
--format [type] : Output format (default: stylish)

### JSON Format

```sh
$ ./bin/gendiff --format json ./tests/fixtures/file1.json ./tests/fixtures/file2.json
{
    "common": {
        "setting1": "Value 1",
        "setting2": "200",
        "setting3": true
    },
    "group1": {
        "baz": "bas",
        "foo": "bar"
    }
}
```

## [List of asciinema]
[![asciicast](https://asciinema.org/a/k7K4FLUV8nYbXbHrgmEFx2csi.svg)](https://asciinema.org/a/k7K4FLUV8nYbXbHrgmEFx2csi)

[![asciicast](https://asciinema.org/a/eB3w2i7ymvGK4xCEr9WAUmOKK.svg)](https://asciinema.org/a/eB3w2i7ymvGK4xCEr9WAUmOKK)

[![asciicast](https://asciinema.org/a/r0G6b480E6InyWmp2p6Nsnwb3.svg)](https://asciinema.org/a/r0G6b480E6InyWmp2p6Nsnwb3)

[![asciicast](https://asciinema.org/a/bo4hlaLbixvta6oWOrRsDMRks.svg)](https://asciinema.org/a/bo4hlaLbixvta6oWOrRsDMRks)

[![asciicast](https://asciinema.org/a/3rmfeADOL7GHOV9CEaC6f69WG.svg)](https://asciinema.org/a/3rmfeADOL7GHOV9CEaC6f69WG)

[![asciicast](https://asciinema.org/a/YEswjH4RLRSDxxFueYEcCHqQ0.svg)](https://asciinema.org/a/YEswjH4RLRSDxxFueYEcCHqQ0)