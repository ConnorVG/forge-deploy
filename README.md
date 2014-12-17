### Installing Deploy

Use the composer `global` command:
```bash
composer global require "connorvg/forge-deploy=~1.0"
```

Make sure to place the `~/.composer/vendor/bin` directory in your PATH so the `forge-deploy` executable is found when you run the `forge-deploy` command in your terminal.

### Usage

Once you have installed, you're ready to add deployments:
```bash
forge-deploy save [name] [endpoint]
```

To update a deployment:
```bash
forge-deploy update [name] [new-endpoint]
```

To delete a deployment:
```bash
  forge-deploy delete [name]
```

Finally, to deploy:
```bash
  forge-deploy deploy [name]
```
