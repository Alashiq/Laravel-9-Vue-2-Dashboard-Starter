#include <iostream>
#include <fstream>
#include <string>

using namespace std;

    struct Column
    {
        std::string name;
        std::string type;
    };


void create_controller(string table, string model)
{
    std::string sourcePath = "Files/Controller.php";
    std::string destinationPath = model + "Controller.php";
    std::ifstream sourceFile(sourcePath, std::ios::binary);
    std::ofstream destinationFile(destinationPath, std::ios::binary);
    std::string data;

    while (std::getline(sourceFile, data))
    {
        if (data.find("xmodel") != std::string::npos)
            data.replace(data.find("xmodel"), 6, model);

        destinationFile << data << "\n";
    }

    destinationFile << sourceFile.rdbuf();

    sourceFile.close();
    destinationFile.close();
}


void create_model(string table, string model,Column column[10],int columnCount)
{
    std::string sourcePath = "Files/Model.php";
    std::string destinationPath = model + ".php";
    std::ifstream sourceFile(sourcePath, std::ios::binary);
    std::ofstream destinationFile(destinationPath, std::ios::binary);
    std::string data;

    while (std::getline(sourceFile, data))
    {
        if (data.find("xmodel") != std::string::npos)
            data.replace(data.find("xmodel"), 6, model);

        if (data.find("xcolumn") != std::string::npos){
            string fill="";
            for(int i=0;i<columnCount;i++){
                fill=fill + "'"+column[i].name+"',\n";
            }
            data.replace(data.find("xcolumn"), 7, fill);  
        }
            

        destinationFile << data << "\n";
    }

    destinationFile << sourceFile.rdbuf();

    sourceFile.close();
    destinationFile.close();
}
