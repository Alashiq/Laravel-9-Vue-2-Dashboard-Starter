#include <iostream>
#include <fstream>
#include <string>


using namespace std;

    struct Column
    {
        std::string name;
        std::string type;
        std::string search;
    };


void create_controller(string table, string model,Column column[20],int columnCount)
{
    std::string sourcePath = "Files/Controller.php";
    std::string destinationPath = model + "Controller.php";
    std::ifstream sourceFile(sourcePath, std::ios::binary);
    std::ofstream destinationFile(destinationPath, std::ios::binary);
    std::string data;

    while (std::getline(sourceFile, data))
    {
        // Change Class Name
        if (data.find("xmodel") != std::string::npos)
            data.replace(data.find("xmodel"), 6, model);

        // Add Search Filter
        if (data.find("//xSearchColumn") != std::string::npos){
            string fill="";
            for(int i=0;i<columnCount;i++){
                if(column[i].search=="y" || column[i].search=="Y"){
                fill=fill + "->where('"+column[i].name+"', 'like', '%' . $request->"+column[i].name+" . '%') \n";
                }
            }
            data.replace(data.find("//xSearchColumn"), 15, fill);  
        }

        // Add Colum to Insert Item
        if (data.find("//xInserColumn") != std::string::npos){
            string fill="";
            for(int i=0;i<columnCount;i++){
                fill=fill + "'"+column[i].name+"' => $request['"+column[i].name+"'], \n";
            }
            data.replace(data.find("//xInserColumn"), 14, fill);  
        }

        destinationFile << data << "\n";
    }

    destinationFile << sourceFile.rdbuf();

    sourceFile.close();
    destinationFile.close();
}


void create_model(string table, string model,Column column[20],int columnCount)
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



void create_table(string table, string model,Column column[20],int columnCount)
{
    // Copy Table File
    std::string sourcePath = "Files/Table.php";
    std::string destinationPath = "create_"+table + "_table.php";
    std::ifstream sourceFile(sourcePath, std::ios::binary);
    std::ofstream destinationFile(destinationPath, std::ios::binary);
    std::string data;

    while (std::getline(sourceFile, data))
    {
        if (data.find("xtable") != std::string::npos)
            data.replace(data.find("xtable"), 6, table);

        if (data.find("xcolumn") != std::string::npos){
            string fill="";
            for(int i=0;i<columnCount;i++){
                
                fill=fill + "$table->"+column[i].type+"('"+column[i].name+"');\n";
            }
            data.replace(data.find("xcolumn"), 7, fill);  
        }
            

        destinationFile << data << "\n";
    }

    destinationFile << sourceFile.rdbuf();

    sourceFile.close();
    destinationFile.close();
    

}
