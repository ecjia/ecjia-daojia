# Easily tail your logs

This package offers an Artisan command to tail the application log. It supports daily and single logs on your local machine.


## Usage

To tail the log you can use this command:

```bash
php artisan tail
```

You can start the output with displaying the last lines in the log by using the `lines`-option.

```bash
php artisan tail --lines=50
```

To filter out stack traces from the output, you can use the `hide-stack-traces`-option.

```bash
php artisan tail --hide-stack-traces
```

It's also possible to fully clear the output buffer after each log item.
This can be useful if you're only interested in the last log entry when debugging.

```bash
php artisan tail --clear
```

