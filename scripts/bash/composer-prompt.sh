# This shell script is just used to include multiple other scripts for the `composer shell` command.
# They were downloaded from their sources so we don't need to worry about system dependencies.

# Git Prompt
# Provides __git_ps1 function
# From https://github.com/git/git/blob/master/contrib/completion/git-prompt.sh
. scripts/bash/git-prompt.sh

# Drush Prompt
# Provides __drush_ps1
# From https://github.com/drush-ops/drush/blob/master/examples/example.prompt.sh
. scripts/bash/drush-prompt.sh
