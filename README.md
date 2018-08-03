# coding_fellowship_2018
# adding a branch for storing devOps scripts and stuff relevant to the coding fellowship
# script.sh - every time this script is run, it will produce a backup of the databases of the 2018 LACRM coding fellowship and store it in an AWS s3 bucket. If run more than once a day, the most recent backup will replace the previous file in the bucket. A backup will expire 30 days after its creation.
